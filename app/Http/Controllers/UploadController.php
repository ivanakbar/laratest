<?php

namespace App\Http\Controllers;

use App\Models\ModelBussiness;
use App\Models\ModelReview;
use App\Models\ModelCategory;
use App\Models\ModelTrx;
use App\Models\ModelUser;
use App\Models\ModelAddress;

use Illuminate\Http\Request;

Class UploadController extends Controller {
    private $bussiness, $category, $address, $trx;
    private $user, $review;

    public function businesses() {
        $loader = array();
        

        $data = $this->getYelp();

        $data = json_decode($data);

        foreach($data->businesses as $tmp) :
            $tmp->review = $this->getReview($tmp->id);

            $this->businesses = new ModelBussiness();

            $this->businesses->uniq_id = $tmp->id;
            $this->businesses->alias = $tmp->alias;
            $this->businesses->name = $tmp->name;
            $this->businesses->image_url = $tmp->image_url;
            $this->businesses->is_closed = $tmp->is_closed;
            $this->businesses->url = $tmp->url;
            $this->businesses->rating = $tmp->rating;
            $this->businesses->lat = $tmp->coordinates->latitude;
            $this->businesses->long = $tmp->coordinates->longitude;
            $this->businesses->phone = $tmp->phone;
            $this->businesses->display_phone = $tmp->display_phone;
            $this->businesses->distance = $tmp->distance;

            $this->businesses->save();

            if($tmp->categories) {
                

                foreach($tmp->categories as $cat) :
                    $this->category = new ModelCategory();

                    $this->category->uniq_id = $tmp->id;
                    $this->category->alias = $cat->alias;
                    $this->category->title = $cat->title;

                    $this->category->save();

                    unset($this->category);
                endforeach;

                
            }

            if($tmp->transactions) {
                

                foreach($tmp->transactions as $trx) :
                    $this->trx = new ModelTrx();

                    $this->trx->uniq_id = $tmp->id;
                    $this->trx->content = $trx;

                    $this->trx->save();

                    unset($this->trx);
                endforeach;

                
            }

            if($tmp->location) {
                $this->address = new ModelAddress();

                $this->address->uniq_id = $tmp->id;
                $this->address->address1 = $tmp->location->address1;
                $this->address->address2 = $tmp->location->address2;
                $this->address->address3 = $tmp->location->address3;
                $this->address->city = $tmp->location->city;
                $this->address->zip_code = $tmp->location->zip_code;
                $this->address->country = $tmp->location->country;
                $this->address->state = $tmp->location->state;
                $this->address->display_address = "";

                $this->address->save();

                unset($this->address);
            }

            $tmp->review = json_decode($tmp->review);

            if($tmp->review->reviews) {
                foreach($tmp->review->reviews as $rev) :
                    $this->review = new ModelReview();
                    $this->user = new ModelUser();

                    $this->review->uniq_id = $tmp->id;
                    $this->review->userid = $rev->user->id;
                    $this->review->url = $rev->url;
                    $this->review->text = $rev->text;
                    $this->review->rating = $rev->rating;
                    $this->review->time_created = $rev->time_created;

                    $this->user->uniq_id = $rev->user->id;
                    $this->user->profile_url = $rev->user->profile_url;
                    $this->user->image_url = $rev->user->image_url;
                    $this->user->name = $rev->user->name;

                    $this->review->save();
                    $this->user->save();

                    unset($this->review);
                    unset($this->user);
                endforeach;
            }

            $loader[] = $this->businesses;

            unset($this->businesses);
        endforeach;  

        return response()->json([
            'status' => '1',
            'message' => 'Success',
            'data' => $loader
            ], 200);
    }

    public function reviews() {
        return response()->json([
            'status' => '1',
            'message' => 'Success',
            'data' => "ok"
            ], 200);

    }

    function getYelp() {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.yelp.com/v3/businesses/search?location=new+york&term=pasta",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Accept: */*",
            "Accept-Encoding: gzip, deflate",
            "Authorization: Bearer 3tAgcgKUqLaZsS4SZP8mNS2B7gK5MB0dNIotIrrOgYHhv6PONlvqb6i2Ato6EpzsxAsCCEBGMKiHkkHR1utk1lxK6Benwg4Dkm5a_Vgb3g4KzF4e_fm_RAOvYbPkXXYx",
            "Cache-Control: no-cache",
            "Connection: keep-alive",
            "Host: api.yelp.com",
            "Postman-Token: baca26ed-7bcf-4012-ad34-351469bfd98e,22e99ca5-c0f3-4bcf-afa4-924586957d04",
            "User-Agent: PostmanRuntime/7.20.1",
            "cache-control: no-cache"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        return "cURL Error #:" . $err;
        } else {
        return $response;
        }
    }

    function getReview($id) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.yelp.com/v3/businesses/$id/reviews",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Accept: */*",
            "Accept-Encoding: gzip, deflate",
            "Authorization: Bearer 3tAgcgKUqLaZsS4SZP8mNS2B7gK5MB0dNIotIrrOgYHhv6PONlvqb6i2Ato6EpzsxAsCCEBGMKiHkkHR1utk1lxK6Benwg4Dkm5a_Vgb3g4KzF4e_fm_RAOvYbPkXXYx",
            "Cache-Control: no-cache",
            "Connection: keep-alive",
            "Host: api.yelp.com",
            "Postman-Token: 7ce23f43-a401-40af-a57d-acd77d4372dc,6ff624ad-9898-4289-b62d-d200b0913b7f",
            "User-Agent: PostmanRuntime/7.20.1",
            "cache-control: no-cache"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        return "cURL Error #:" . $err;
        } else {
        return $response;
        }
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\ModelBussiness;
use App\Models\ModelReview;
use App\Models\ModelCategory;
use App\Models\ModelTrx;
use App\Models\ModelUser;
use App\Models\ModelAddress;

use Illuminate\Http\Request;

Class BussinessController extends Controller {
    private $bussiness, $category, $address, $trx;
    private $user, $review;

    public function get() {
        $data = ModelBussiness::all();
        $res = array();

        foreach($data as $d) :
            $d->categories = $this->getcategory($d->uniq_id);
            $d->transactions = $this->gettrx($d->uniq_id);
            $d->location = $this->getlocation($d->uniq_id);

            $res[] = $d;
        endforeach;

        return response()->json([
            'status' => '1',
            'message' => 'Success',
            'data' => $res
            ], 200);
    }

    public function getPagination($limit, $page) {
        $offset = $page * $limit;
        //$data = ModelBussiness::all();
        $data = ModelBussiness::skip($offset)->take($limit)->get();
        $res = array();

        foreach($data as $d) :
            $d->categories = $this->getcategory($d->uniq_id);
            $d->transactions = $this->gettrx($d->uniq_id);
            $d->location = $this->getlocation($d->uniq_id);

            $res[] = $d;
        endforeach;

        return response()->json([
            'status' => '1',
            'message' => 'Success',
            'data' => $res
            ], 200);
    }

    function getcategory($id) {
        $data = ModelCategory::where('uniq_id',$id)->get();

        return $data;
    }

    function gettrx($id) {
        $data = ModelTrx::where('uniq_id',$id)->get();

        return $data;
    }

    function getlocation($id) {
        $data = ModelAddress::where('uniq_id',$id)->get();

        return $data;
    }

    public function getOne($id) {
        $data = ModelBussiness::where('id',$id)->get();
        $res = array();

        foreach($data as $d) :
            $d->categories = $this->getcategory($d->uniq_id);
            $d->transactions = $this->gettrx($d->uniq_id);
            $d->location = $this->getlocation($d->uniq_id);

            $res[] = $d;
        endforeach;

        return response()->json([
            'status' => '1',
            'message' => 'Success',
            'data' => $res
            ], 200);
    }

    public function store(Request $request) {
        $this->businesses = new ModelBussiness();

        $this->businesses->uniq_id = $request->id;
        $this->businesses->alias = $request->alias;
        $this->businesses->name = $request->name;
        $this->businesses->image_url = $request->image_url;
        $this->businesses->is_closed = $request->is_closed;
        $this->businesses->url = $request->url;
        $this->businesses->rating = $request->rating;

        $request->coordinates = json_decode(json_encode($request->coordinates));

        $this->businesses->lat = $request->coordinates->latitude;
        $this->businesses->long = $request->coordinates->longitude;
        
        $this->businesses->phone = $request->phone;
        $this->businesses->display_phone = $request->display_phone;
        $this->businesses->distance = $request->distance;

        $this->businesses->save();

        $request->categories = json_decode(json_encode($request->categories));
        if($request->categories) {
            foreach($request->categories as $cat) :
                $this->category = new ModelCategory();

                $this->category->uniq_id = $request->id;
                $this->category->alias = $cat->alias;
                $this->category->title = $cat->title;

                $this->category->save();

                unset($this->category);
            endforeach;
        }

        $request->transactions = json_decode(json_encode($request->transactions));
        if($request->transactions) {
            foreach($request->transactions as $trx) :
                $this->trx = new ModelTrx();

                $this->trx->uniq_id = $request->id;
                $this->trx->content = $trx;

                $this->trx->save();

                unset($this->trx);
            endforeach;
        }

        $request->location = json_decode(json_encode($request->location));
        if($request->location) {
            $this->address = new ModelAddress();

            $this->address->uniq_id = $request->id;
            $this->address->address1 = $request->location->address1;
            $this->address->address2 = $request->location->address2;
            $this->address->address3 = $request->location->address3;
            $this->address->city = $request->location->city;
            $this->address->zip_code = $request->location->zip_code;
            $this->address->country = $request->location->country;
            $this->address->state = $request->location->state;
            $this->address->display_address = "";

            $this->address->save();

            unset($this->address);
        }

        return response()->json([
            'status' => '1',
            'message' => 'Data has been added',
            'data' => $this->businesses
            ], 200);
    }

    public function update(Request $request, $id="") {
        return response()->json([
            'status' => '1',
            'message' => 'No function yet',
            'data' => 'No function yet'
            ], 200);
    }

    public function destroy($id="") {
        return response()->json([
            'status' => '1',
            'message' => 'No function yet',
            'data' => 'No function yet'
            ], 200);
    }
}
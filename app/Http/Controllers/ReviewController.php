<?php

namespace App\Http\Controllers;

use App\Models\ModelBussiness;
use App\Models\ModelReview;
use App\Models\ModelCategory;
use App\Models\ModelTrx;
use App\Models\ModelUser;
use App\Models\ModelAddress;

use Illuminate\Http\Request;

Class ReviewController extends Controller {
    private $bussiness, $category, $address, $trx;
    private $user, $review;

    public function getOne($id) {
        $data = ModelReview::where('id',$id)->get();
        $res = array();

        foreach($data as $d) :
            $d->user = $this->getuser($d->userid);

            $res[] = $d;
        endforeach;

        return response()->json([
            'status' => '1',
            'message' => 'Success',
            'data' => $res
            ], 200);
    }

    public function getUniq($id) {
        $data = ModelReview::where('uniq_id',$id)->get();
        $res = array();

        foreach($data as $d) :
            $d->user = $this->getuser($d->userid);

            $res[] = $d;
        endforeach;

        return response()->json([
            'status' => '1',
            'message' => 'Success',
            'data' => $res
            ], 200);
    }

    function getuser($id) {
        $data = ModelUser::where('uniq_id',$id)->get();

        return $data;
    }

    function store(Request $request) {
        $this->review = new ModelReview();
        $this->user = new ModelUser();

        $request->user = json_decode(json_encode($request->user));

        $this->review->uniq_id = $request->uniq_id;
        $this->review->userid = $request->user->id;
        $this->review->url = $request->url;
        $this->review->text = $request->text;
        $this->review->rating = $request->rating;
        $this->review->time_created = $request->time_created;

        $this->user->uniq_id = $request->user->id;
        $this->user->profile_url = $request->user->profile_url;
        $this->user->image_url = $request->user->image_url;
        $this->user->name = $request->user->name;

        $this->review->save();
        $this->user->save();

        return response()->json([
            'status' => '1',
            'message' => 'Data has been added',
            'data' => $this->review
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
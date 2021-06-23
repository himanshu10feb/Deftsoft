<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use File;
use App\Image;

class ImageController extends Controller
{
    public function index(Request $request){
        $images = Image::all(); 
       
        return view("upload_image.multiple_image")->with(compact('images'));
    }

    public function uploadimage(Request $request){

        if($request->isMethod('post')){
            $data = $request->all();
            //dd($data); die;
            if($request->hasFile('image')){
               $files = $request->file('image');
               foreach($files as $file){
                  $image = new Image;
                  $extension = $file->getClientOriginalExtension();
                  $filename = rand(111,9999).'.'.$extension;
                  $file->move('upload',  $filename); 
                  $image->image=$filename ;
                 
                  $image->save();
               }
              
            }
       
            return redirect("/index")->with("flesh-message-success", "File Upload Successfully!!");
    }
}
         public function delete(Request $request){
          //  dd($request->images);
           $image_path = 'upload/';
           if(isset($request->images) && is_array($request->images)){
            foreach($request->images as $image){
              if(file_exists($image_path.$image)){

                @unlink($image_path.$image);
                Image::where(['image'=>$image])->delete();
             }
            
            }
            return redirect("/index")->with("flesh-message-success", "File Deleted Successfully!!");
           } else {
             //Put a session message for please select at least one Image
             return redirect("/index")->with("flesh-message-error", "Something Went Worng Plese Select Atlest 1 File!");
           }
           

          //  $del = Image::find($id);
           
  }
  public function deleteimage(Request $request, $imagename){
    
    $image_path = 'upload/';
  
    
    if(file_exists($image_path.$imagename)){

      @unlink($image_path.$imagename);
      Image::where(['image'=>$imagename])->delete();
    }
    return redirect()->back();
  }
public function singalimage(Request $request){
    //dd($request->all()); die;
    $image_path = 'upload/';
    $file = $request->newimage;
    $image = new Image;
    $extension = $file->getClientOriginalExtension();
    $filename = rand(111,9999).'.'.$extension;
    $file->move('upload',  $filename); 
    // $image = Image::where(['image'=>$request->oldimage]);
    // $image->image=$filename;
    // if($image->save()){
    //   return response()->json([
    //             'message' => "data save successfully!!",
    //             "code" => 200,
    //             "data" =>  $image
    //   ],200);
    // }else{
    //   return response()->json([
    //             'message' => "data not save!!",
    //             "code" => 500,
    //             "data" =>  $image
    //   ],500);
    // }
    Image::where('image', $request->oldimage)
      ->update(['image' => $filename]);
    if(file_exists($image_path.$request->oldimage)){

      @unlink($image_path.$request->oldimage);
      // Image::where(['image'=>$image])->delete();
   }
}
 
}

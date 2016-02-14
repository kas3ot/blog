<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\request;
use App\Story as Story;	//story model
use App\User as User;	//user model
use App\Comment as Comment; //comment model
use Crypt;	//crypting
use Validator;	//validim
use \Auth as Auth;	//current logged in user
use Image; //image for resize and upload
use File; //file for resize and upload

class StoryController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function owner($id){

		$story = Story::findOrFail($id);

		if($story->user_id == Auth::user()->id){

			return true;
		}

		return false;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$stories = Story::orderBy('id', 'desc')->get();
		
		return view('story.index', compact('stories'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('story.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$this->validate($request, [
						'name' => 'required|min:3', 
						'description' => 'required',
						'photo' => 'image|image_size:<=300'
						]);
		
    	$input = $request->all();

    	$fileName = '';

    	if( $request->hasFile('photo') ) {

       		$file = $request->file('photo');
        	
        	$fileName =  $file->getClientOriginalName();

        	Image::make($file->getRealPath())->resize('64','64')->save('images/'.$fileName);

			$input['photo'] = $fileName;

		}

		$input['user_id'] = Crypt::decrypt($input['user_id']);

		Story::create($input);

		flash()->success('Story has been created!');

		return redirect('/stories');

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$story = Story::where('id', $id)->first();

		return view('story.story', compact('story'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$story = Story::findOrFail($id);

		if($this->owner($id)){
			return view('story.edit', compact('story'));
		}
		
		flash()->error('You are not authorized.');

		return redirect('/');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{

		$story = Story::findOrFail($id);

		$this->validate($request, [
						'name' 		  => 'required|min:3', 
						'description' => 'required',
						'photo' 	  => 'image|image_size:<=300'
					]);

		$input = $request->all();
		
		$fileName = $story->photo;

    	if( $request->hasFile('photo') ) {
    		
       		$file = $request->file('photo');
        	
        	$fileName =  $file->getClientOriginalName();

        	Image::make($file->getRealPath())->resize('64','64')->save('images/'.$fileName);

		}

		$input['photo'] = $fileName;

		$input['user_id'] = Crypt::decrypt($input['user_id']);

		$story->update($input);

		flash()->success('Story updated!');

		return redirect('/stories');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */

	public function destroy($id)
	{
		$story = Story::findOrFail($id);

		if($this->owner($id)){

			$fileName = $story->photo;
			
			File::delete('images/' . $fileName);

			$story->delete();

			flash()->info('Story removed!');

			return redirect('/');

		}
		else{

			flash()->error('You are not authorized!');

			return redirect('/');

		}
	}


	/*
	* Show all the stories of that user
	*/

	public function myStories(){
		
		$stories = Story::where("user_id", "=", Auth::user()->id)->orderBy('id', 'DESC')->get();

		if (!$stories->isEmpty()) { 
			
			return view('story.my_stories', compact('stories'));
		}
		else{
			
			flash()->warning('You have not created stories yet!');

			return redirect('/');
		}

	}

	public function addComment(Request $request){

		$this->validate($request, [
						'comment'  => 'required'
					]);

		$input = $request->all();

		$input['user_id'] = Crypt::decrypt($input['user_id']);

		$input['story_id'] = Crypt::decrypt($input['story_id']);

		Comment::create($input);

		flash()->success('You have commented.');

		return redirect()->back();

	}
}

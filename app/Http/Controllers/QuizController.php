<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Image;

class QuizController extends Controller
{

	//########## show the version ,class name subject  and quize information from carrd table ########
	public function index(){
		$card_data = DB::table('card')
		->join('virson', 'card.version','=','virson.id')
		->join('class', 'card.class','=','class.id')
		->join('subject', 'card.subject','=','subject.id')
		->join('quiz', 'card.quiz','=','quiz.id')
		->select('card.id','virson.virson','class.class','subject.subject','quiz.title')
		->get();
		return view('pages.home',['card'=>$card_data]);
	}


	//######################### edite version class subject and quize answer in home page (home menu) start ########################

	public function edit_item(){
		$id = $_GET['id'];
		$card_data = DB::table('card')
		->join('virson', 'card.version','=','virson.id')
		->join('class', 'card.class','=','class.id')
		->join('subject', 'card.subject','=','subject.id')
		->join('quiz', 'card.quiz','=','quiz.id')
		->select('card.id','virson.virson','class.class','subject.subject','quiz.title')
		->where('card.id','=',$id)
		->get();

		$verson = $data=DB::table('virson')->select('*')->get();
		$quiz = $data=DB::table('quiz')->select('*')->get();
		?>
		<!--  ############## edit Model popup element start ############# -->
		<input type="hidden" id="_token" name="_token" value="<?php echo csrf_token();?>">
		<input type="hidden" id="id" name="id" value="<?php echo $id ?>">
		<div class="col-md-3">
			<div class="form-group">
				<label for="email">Version:</label>
				<select class="form-control" id="version" onclick="select_class()">
					<option selected="true" disabled>Select one</option>
					<?php
					foreach($verson as $row){?>
						<option <?php if($card_data[0]->virson == $row->virson){ echo "selected";}?>  value="<?php echo $row->id;?>"><?php echo $row->virson;?></option>
						<?php
					}
					?>
				</select>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="email">Class:</label>
				<select class="form-control" id="class" onclick="select_subject()">
					<option selected="true" disabled>Select one</option>
				</select>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="email">Subject:</label>
				<select class="form-control" id="subject">
					<option selected="true" disabled>Select one</option>
				</select>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="email">Common Quize:</label>
				<select class="form-control" id="quiz" onclick="fetch_quiz()">
					<option selected="true" disabled>common quiz</option>
					<?php
					foreach($quiz as $value){?>
						<option <?php if($card_data[0]->title == $value->title){ echo "selected";}?>   value="<?php echo $value->id;?>"><?php echo $value->title;?></option>
						<?php
					}
					?>
				</select>
			</div>
		</div>
		<!--  ############## edit Model popup element End ############# -->

		<?php
	}

	//######################### edite version class subject and quize answer in home page (home menu) start ########################


	################### Delete item from report table start ################

	public function delete_item(){
		$id = $_GET['id'];
		$response = DB::table('card')->delete($id);
		if($response){
			echo "success";
		}
	}

	################### Delete item from report table End ################




	####################### Home page view  Start ######################
	public function report(){
		$verson = $data=DB::table('virson')->select('*')->get();
		$quiz = $data=DB::table('quiz')->select('*')->get();
		return view('pages.report',['verson'=>$verson,'quiz'=>$quiz]);
	}
	####################### Home page view  Start ######################



	################### Dynamic dependent dropdown menu Start (Quiz menu ) Start #############

	################## fetch class which are releted to version #######################
	public function fetch_class(){
		$version = $_GET['version'];
		$class = $data=DB::table('class')->select('*')->where('virson_id','=',$version)->get();

		$output  = "<option selected='true' disabled>Select one</option>";
		foreach ($class as $key => $value) {?>
			<option value="<?php echo $value->id;?>"><?php echo $value->class;?></option>
			<?php
		}
	}

	################## fetch Subject  which are releted to Class #######################
	public function fetch_subject(){
		$classes = $_GET['classes'];
		$subject = $data=DB::table('subject')->select('*')->where('class_id','=',$classes)->get();

		$output  = "<option selected='true' disabled>Select one</option>";
		foreach ($subject as $key => $value) {?>
			<option value="<?php echo $value->id;?>"><?php echo $value->subject;?></option>
			<?php
		}
	}

	################## fetch All quiz data rhat are uploaded to the quizequestion database which are releted to version #######################

	public function fetch_quiz(){
		$quiz_id = $_GET['quiz_id'];
		$quiz_question = $data=DB::table('quizquestion')->select('*')->where('quiz_id','=',$quiz_id)->get();

		$question_ids = array();

		foreach ($quiz_question as $key => $row) {?>
			<div class="col-md-6">
				<p><?php echo $row->question;?></p>
				<div class="radio">
					<label><input type="radio" value="<?php echo $row->option1?>" name="<?php echo $row->id;?>"><?php echo $row->option1;?></label>
				</div>
				<div class="radio">
					<label><input type="radio" value="<?php echo $row->option2?>" name="<?php echo $row->id;?>"><?php echo $row->option2;?></label>
				</div>
				<div class="radio disabled">
					<label><input type="radio" value="<?php echo $row->option3?>" name="<?php echo $row->id;?>"><?php echo $row->option3;?></label>
				</div>
				<div class="radio disabled">
					<label><input type="radio" value="<?php echo $row->option4?>" name="<?php echo $row->id;?>"><?php echo $row->option4;?></label>
				</div>
			</div>
			<?php
			array_push($question_ids, $row->id);		}
			?>
			<input type="hidden" id="questionid" value="<?php echo implode(',',$question_ids);?>">
			<div class="col-md-1">	
				<button class="btn btn-success rounded ml-5" onclick="submit()">Submit</button>
			</div>
			<?php
		}


		################### Dynamic dependent dropdown menu Start (Quiz menu ) Start #############

		########################## Store quiz result which are submitted by user from quize menu ######

		public function store(Request $request){
			$version = $request->version;
			$classes = $request->classes;
			$subject = $request->subject;
			$quiz    = $request->quiz;
			$answer  = $request->answer;

			$response = DB::table('card')->insert(['version'=>$version,'class'=>$classes,'subject'=>$subject,'quiz'=>$quiz]);
			if($response){
				foreach ($answer as $key => $value) {
					$res= DB::table('quiz_result')->insert(['quiz_id'=>$quiz,'question'=>$value['question'],'answer'=>$value['answer']]);
					if($res){
						echo "success";
					}
				}
			}		
		}


		############# Update quiz result and releted version class subject from home table edit option #######
		public function update(Request $request){
			$id = $request->id;
			$version = $request->version;
			$classes = $request->classes;
			$subject = $request->subject;
			$quiz    = $request->quiz;
			$answer  = $request->answer;

			$response = DB::table('card')->where('id',$id)->update(['version'=>$version,'class'=>$classes,'subject'=>$subject,'quiz'=>$quiz]);
			if($response){
				foreach ($answer as $key => $value) {
					$res= DB::table('quiz_result')->where([['quiz_id',$quiz],['question',$value['question']]])->update(['answer'=>$value['answer']]);
					if($res){
						echo "success";
					}
				}
			}
		}

		###################### Upload image from image upload menu image faced is use to save image ,get extention and time method for rename image unique name #############

		public function image_upload(Request $request){
			$image = $image=$request->file('image');
			$extention=$image->getClientOriginalExtension();//File Extention
			$product_img=time().'.'.$extention;
			$image_resize = Image::make($image->getRealPath());   
			$image_resize->resize(70,70);
			$image_resize->save('images/'.$product_img);

			$response = DB::table('image')->insert(['image'=>$product_img]);
			if($response){
				return redirect('/image')->with('status', 'Record inserted successfully!');
			}
		}

		############## api for get card data from the out side the application or another application ###### api link http://127.0.0.1:8000/api/cardinfo ########

		public function apidata(){
			$card_data = DB::table('card')
			->join('virson', 'card.version','=','virson.id')
			->join('class', 'card.class','=','class.id')
			->join('subject', 'card.subject','=','subject.id')
			->join('quiz', 'card.quiz','=','quiz.id')
			->select('card.id','virson.virson','class.class','subject.subject','quiz.title')
			->get();
			echo json_encode($card_data);
		}
	}
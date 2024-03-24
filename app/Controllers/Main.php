<?php

namespace App\Controllers;
use App\Models\Auth;
use CodeIgniter\Files\File;
use CodeIgniter\HTTP\Files\UploadedFile;
class Main extends BaseController
{   
    protected $request;

    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->session = session();
        $this->auth_model = new Auth;
        $this->data = ['session' => $this->session];
    }

    public function index()
    {
        $this->data['page_title']="Home";
        return view('pages/home', $this->data);
    }

    public function users(){
        if($this->session->login_type != 1){
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $this->data['page_title']="Users";
        $this->data['page'] =  !empty($this->request->getVar('page')) ? $this->request->getVar('page') : 1;
        $this->data['perPage'] =  10;
        $this->data['total'] =  $this->auth_model->where("id != '{$this->session->login_id}'")->countAllResults();
        $this->data['users'] = $this->auth_model->where("id != '{$this->session->login_id}'")->paginate($this->data['perPage']);
        $this->data['total_res'] = is_array($this->data['users'])? count($this->data['users']) : 0;
        $this->data['pager'] = $this->auth_model->pager;
        return view('pages/users/list', $this->data);
    }
    public function user_edit($id=''){
        if($this->session->login_type != 1){
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        if(empty($id))
        return redirect()->to('Main/users');
        if($this->request->getMethod() == 'post'){
            extract($this->request->getPost());
			$password = rand(1,10);
			$udata= [];
			$udata['name'] = $name;
			$udata['last_name'] = $last_name;
			$udata['email'] = $email;
			$udata['password'] = password_hash($password, PASSWORD_DEFAULT);
			$udata['country_code'] = $country_code;
			$udata['mobile'] = $mobile;
			$udata['address'] = $address;
			$udata['gender'] = $gender;
			if(isset($hobby)){
				$hobby= implode(',',$hobby);
			}else{
				$hobby= 0;
			}
			$udata['hobby'] = $hobby;
			$udata['status'] = 1;
			$udata['type'] = 0;
			
			$img = $this->request->getFile('image');
			$image = $img->getName();
			$uploaded_fileinfo = null;	
			if($image != ''){	
				$validationRule = [
					'image' => [
						'label' => 'Image File',
						'rules' => [
							'uploaded[image]',
							'is_image[image]',
							'mime_in[image,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
							//'max_size[image,100]',
							//'max_dims[image,1024,768]',
						],
					],
				];

				if (! $this->validate($validationRule)) {
				$this->session->setFlashdata('error','Only jpg, jpeg, gif, png, webp file type allowd!');
				return redirect()->to('Main/user_edit/'.$id);
				}

				$img = $this->request->getFile('image');
				// Generate a unique name for the file
				$newName = $img->getRandomName();
				$uploaded_fileinfo = $newName;	
				// Move the file to the writable/uploads directory
				$img->move(ROOTPATH . 'writable/uploads', $uploaded_fileinfo);
				$udata['image'] = $uploaded_fileinfo;
			}
			
			$update = $this->auth_model->where('id',$id)->set($udata)->update();	
			if($update){
				$this->session->setFlashdata('success',"User Details has been updated successfully.");
				return redirect()->to('Main/user_edit/'.$id);
			}else{
				$this->session->setFlashdata('error',"User Details has failed to update.");
			}            
        }

        $this->data['page_title']="Users";
        $this->data['user'] = $this->auth_model->where("id ='{$id}'")->first();
		$this->data['country_array'] = $this->getCountryCode();		
		$this->data['hobby_array'] = $this->gethobbyArray();
        return view('pages/users/edit', $this->data);
    }
    
    public function user_delete($id=''){
        if($this->session->login_type != 1){
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        if(empty($id)){
                $this->session->setFlashdata('main_error',"user Deletion failed due to unknown ID.");
                return redirect()->to('Main/users');
        }
		$userInfo = $this->auth_model->find($id);
        $delete = $this->auth_model->where('id', $id)->delete();
        if($delete){
			if(isset($userInfo['image']) && $userInfo['image']!=''){
			
				 $userImage = $userInfo['image'];
				 $path = ROOTPATH . '/writable/uploads/'.$userImage; 
				 if(file_exists($path) && $userImage != ''){ 
				 unlink($path); 
				 }
			}
            $this->session->setFlashdata('main_success',"User has been deleted successfully.");
        }else{
            $this->session->setFlashdata('main_error',"user Deletion failed due to unknown ID.");
        }
        return redirect()->to('Main/users');
    }
	
	public function register_user(){
        $session = session();
        $data=[];
        $data['session'] = $session;
        $data['data'] = $this->request;
        $data['page_title'] = "Registraion";		
		$this->data['country_array'] = $this->getCountryCode();
		$this->data['hobby_array'] = $this->gethobbyArray();
		
		
        $this->data['user'] = array();
        if($this->request->getMethod() == 'post'){
            $name = $this->request->getPost('name');
			$email = $this->request->getPost('email');
            $last_name = $this->request->getPost('last_name');
			$email = $email; 
			$country_code = $this->request->getPost('country_code'); 
			$mobile = $this->request->getPost('mobile');
			$address = $this->request->getPost('address');
			$gender = $this->request->getPost('gender');
			$hobby= $this->request->getPost('hobby');
			if(isset($hobby) && $hobby != ''){
				$hobby_arr = $this->request->getPost('hobby');
				$hobby = implode(',',$hobby_arr);
			}else{
				$hobby= 0;
			}
            $checkEmail = $this->auth_model->where('email', $email)->countAllResults();
			$password ='12345678';
			
			$img = $this->request->getFile('image');
			$image = $img->getName();
			
			$this->data['user'] = array('name'=>$name,'email'=>$email, 'last_name' => $last_name,'country_code' => $country_code, 'mobile' => $mobile, 'address' => $address, 'gender' => $gender, 'hobby' => $hobby, 'image' => $image );
            if($checkEmail > 0){
                $session->setFlashdata('error','Email is already taken.');
            }else{	
			
			if($image != ''){
				$uploaded_fileinfo = null;					
				$validationRule = [
					'image' => [
						'label' => 'Image File',
						'rules' => [
							'uploaded[image]',
							'is_image[image]',
							'mime_in[image,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
							//'max_size[image,100]',
							//'max_dims[image,1024,768]',
						],
					],
				];

				if (! $this->validate($validationRule)) {
				$this->session->setFlashdata('error','Only jpg, jpeg, gif, png, webp file type allowd!');
				return redirect()->to('Main/user_edit/'.$id);
				}

				$img = $this->request->getFile('image');
				// Generate a unique name for the file
				$newName = $img->getRandomName();
				$uploaded_fileinfo = $newName;	
				// Move the file to the writable/uploads directory
				$img->move(ROOTPATH . 'writable/uploads', $uploaded_fileinfo);
				$idata = ['name' => $name,
							'last_name' => $last_name,
                           'email' => $email, 
						   'password' => password_hash($password, PASSWORD_DEFAULT),
						   'mobile' => $mobile,
                           'country_code' => $country_code,
						   'address' => $address,
						   'gender' => $gender,
						   'hobby' => $hobby,
						   'image' => $uploaded_fileinfo,
                           'status' => 1,
                           'type' =>0     
                        ];
			}else{
				$idata = ['name' => $name,
							'last_name' => $last_name,
                           'email' => $email, 
						   'password' => password_hash($password, PASSWORD_DEFAULT),
						   'mobile' => $mobile,
                           'country_code' => $country_code,
						   'address' => $address,
						   'gender' => $gender,
						   'hobby' => $hobby,
                           'status' => 1,
                           'type' =>0     
                        ];
			}
				
				 
                $save = $this->auth_model->save($idata);
                if($save){
                    $session->setFlashdata('success','Your Account has been register sucessfully.');
                   // return redirect()->to('Auth');
				   return redirect()->to('Main/users');
                }
            }
        }
		
		
        return view('pages/users/register_user', $this->data);
    }
	
	
	public function getCountryCode (){
		$countries = array( '1' => 'US', '2' => 'UK', '3' => 'DE', '44' => 'FI', '123' => 'NO', '971' =>'UAE', '91' =>'IND', '92' =>'PAK' );
		return $countries;
	}
	public function gethobbyArray (){
		$hobbyArray =array(
					array('id' => '1', 'label' => 'Reading'),
					array('id' => '2', 'label' => 'Swimming'),
					array('id' => '3', 'label' => 'Dance'),
					array('id' => '4', 'label' => 'Running'));
		return $hobbyArray;
	}	
}

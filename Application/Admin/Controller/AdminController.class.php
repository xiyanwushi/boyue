<?php
namespace Admin\Controller;
use Think\Controller;
class AdminController extends Controller {
    public function _initialize(){
		// 权限判断，Index控制器的不需要登录，其他的必须登录后才可以浏览
		if(CONTROLLER_NAME != 'Index' && !session('?admin')){
			$this -> error('请登陆后操作!', U('Index/login'));
			exit;
		}
		
		// _开头的函数为内部函数，不能直接访问
		if(substr(ACTION_NAME,0,1) == '_'){
			$this -> error('访问地址错误！', U('Index/index'));
		}
		
		$this->admin = session('admin');
		
		// 从数据读取配置参数
		$config = M('config') -> select();
		foreach($config as $v){
			$key = '_'.$v['name'];
			$this -> $key = unserialize($v['value']);
			$_CFG[$v['name']] = $this -> $key;
		}
		$this -> assign('_CFG', $_CFG);
		$GLOBALS['_CFG'] = $_CFG;
		
		
		//获取当前登录角色
		$role = M('role')->where(array('id'=>$this->admin['role_id']))->find();
		
		
		//获取菜单
		$mp['status'] = 1;
		$mp['id'] = array('in',$role['rules']);
		$me = M('menu')->where($mp)->order('sort desc,id asc')->select();
		$menu = list_to_tree($me);
		$this->assign('menu',$menu);
    }
	
	// 后台首界面
	public function welcome(){
		
		$this -> assign('info', $info);
		$this -> display();
	}

	
	// 通用简单列表方法
	protected function _list($table, $where= null, $order = null){
		$list = $this -> _get_list($table, $where, $order);
		$this -> assign('list', $list);
		$this -> assign('page', $this -> data['page']);
		$this -> display();
	}
	
	// 获得一个列表,返回而不输出
	protected function _get_list($table, $where= null, $order = null){
		$model = M($table);
		$count = $model -> where($where) -> count();
		$page = new \Think\Page($count, 25);
		if(!$order){
			$order = "id desc";
		}
		$list = $model -> where($where) -> limit($page -> firstRow . ',' . $page -> listRows ) -> order($order) -> select();
		//echo M()->getLastSql();
		
		// 将数据保存到成员变量
		$this -> data = array(
			'list' => $list,
			'page' => $page -> show(),
			'count' => $count
		);
		
		return $list;
	}
	
	// 通用编辑方法,根据POST自动增加或者修改
	protected function _edit($table, $url = null){
		$model = M($table);
		
		$id = intval($_GET['id']);
		if($id>0){
			$info = $model -> find($id);
			if(!$info)
				die('信息不存在');
			
			$this -> assign('info', $info);
		}
		if(IS_POST){
			if(!$url)
				$url = U('index');
			if($id>0){
				$_POST['id'] = $id;
				$model -> save($_POST);
				$this -> success('操作成功！', $url);
				exit;
			}else{
				$model -> add($_POST);
				$this -> success('添加成功！', $url);
				exit;
			}
		}
		
		$this -> display();
	}
	
	// 通用删除
	protected function _del($table,$id){
		if($id>0 && !empty($table)){
			M($table) -> delete($id);
		}
	}
	
	// 上传图片
	public function upload(){
		if(!empty($_GET['url']))
			$this -> assign('url', $_GET['url']);
		if(IS_POST){
			
			if($_GET['field'])
				$field = $_GET['field'];
			if(empty($field))
				$field = 'file';
			
			if($_FILES[$field]['size'] < 1 && $_FILES[$field]['size']>0){
				$this -> assign('errmsg', '上传错误！');
			}else{
				$ext = $this -> _get_ext($_FILES[$field]['name']);
				if(!in_array(strtolower($ext),array('jpg','jpeg','gif','png'))){
					$this -> error('请上传正确的图片');
				}
				$new_name = $this -> _get_new_name($ext, 'images');
				if(move_uploaded_file($_FILES[$field]['tmp_name'], $new_name['fullname'])){
					$this -> assign('url', $new_name['fullname']);
				}else
					$this -> assign('errmsg', '文件保存错误！');
				
				
			}
		}
		C('LAYOUT_ON', false);
		$this -> display('Admin/upload');
	}
	
	/**
	*	根据文件名获取后缀
	*/
	private function _get_ext($file_name){
        return substr(strtolower(strrchr($file_name, '.')),1);
    }

    /**
	*	根据文件类型(后缀)生成文件名和路径
	*	@param return array('name', 'fullname' )
	*	* 文件名取时间戳和随机数的36进制而不是62进制是为了防止windows下大小写不敏感导致文件重名
	*/
	private function _get_new_name($ext, $dir = 'default'){
        $name 		= date('His') . substr(microtime(),2,8) . rand(1000,9999) . '.' . $ext;
        $path 		= './Public/upload/' . $dir . date('/ym/d') .'/';

        // 如果路径不存在则递归创建
        if(!is_dir($_SERVER['DOCUMENT_ROOT'].__ROOT__ . $path)){
        	mkdir($_SERVER['DOCUMENT_ROOT'] .__ROOT__. $path, 0777, 1);
        }

        return array(
        		'name'		=> $name,
        		'fullname'	=> $path . $name
        	);
    }
	
	
	
	//64位上传图片
	public function upload_64(){
        $base64_image_content = I("post.img");
        $image_name = I("post.name");
        $len = I("post.size");
		$user_id = I("post.user_id");
        $baseLen = strlen($base64_image_content);
        if($len!=$baseLen)  $this->error("上传图片不完整");
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){
            $uploadFolder  = './Uploads/images/'.date("Ymd")."/";

            if (!is_dir($uploadFolder)) {
                mkdir($uploadFolder, 0755, true);
            }
            $type = $result[2];
            if(empty($image_name)){
                $new_file = $uploadFolder.date("YmdHis")."_".mt_rand(0, 1000).".{$type}";
            }else{
                $new_file = $uploadFolder.$image_name."_".date("mdHis").".{$type}";
            }
            
            if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))){
                $this->success($new_file);
            }
        }else{
            $this->error("图片不存在");
        }
        
    }
}?>
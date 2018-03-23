<?php
namespace Admin\Controller;
use Think\Controller;
class ConfigController extends AdminController {
	public function _initialize(){
		parent::_initialize();
	}
	
	// 站点设置
	public function site(){
		$this -> _save();
		$this -> display();
	}
	
	//申请商户协议
	public function xy(){
		$this -> _save();
		$this -> display();
	}
	
	//短信平台
	public function sms(){
		$this -> _save();
		$this -> display();
	}
	
	// 物流设置
	public function withdraw(){
		$this -> _save();
		$this -> display();
	}
	
	// 配置管理账号
	public function useredit(){		
		if($_POST['pass']){
			if($_POST['pass'] && $_POST['pass'] != $_POST['pass2']){
				$this->error('两次密码不一致');
				exit;
			}else{
				$_POST['pass'] = xmd5($_POST['pass']);
				unset($_POST['pass2']);
			}
		}else{
			unset($_POST['pass']);
			unset($_POST['pass2']);
		}
		
		$this->assign('role',M('role')->select());
		$this->_edit('admin',U('userlist'));
	}
	
	public function userlist(){
		$this->_list('admin');
	}
	
	public function delUser(){
		$this->_del($_GET['table'],$_GET['id']);
		$this->success('删除成功',U('userlist'));
	}
	
	// 配置公众号
	public function mp(){
		if(IS_POST){
			if(!empty($_FILES['cert']) && $_FILES['cert']['name'] == 'cert.zip'){
				 $upload = new \Think\Upload();
				 $upload->maxSize   =     3145728 ;
				 $upload->exts      =     array('zip');
				 $upload->rootPath  =     './Public/cert/';
				 $upload->savePath  =     xmd5(time().rand()).'/';
				 $upload ->autoSub = false;
				 $info   =   $upload->upload();
				 if($info){
					$info = $info['cert'];
					
					// 解压
					$path = $upload->rootPath . $info['savepath'];
					$file = $path . $info['savename'];
					
					if(file_exists($file)){
						// 打开压缩文件
						$zip = new \ZipArchive();
						$rs = $zip -> open($file);
						if($rs && $zip -> extractTo($path)){
							$zip -> close();
							$_POST['cert'] = $path;
						}
						else{
							$this -> error('解压失败，请确认上传了正确的cert.zip');
						}
					}
					else{
						$this -> error('系统没找到上传的文件');
					}
				 }
				 else {
					$this -> error('证书上传错误');
				 }
			}
			else{
				$_POST['cert'] = $this -> _mp['cert'];
			}
		}
		$this -> _save();
		$this -> display();
	}
	
	
	
	// 分销设置
	public function dist(){		
		$this -> _save();
		$this -> display();
	}
	
	// 商户设置
	public function mch(){
		$this -> _save();
		$this -> display();
	}
	
	
	// 配置等级
	public function level(){
		if(IS_POST){
			$config = array();
			foreach($_POST['name'] as $key => $val){
				if(empty($val)){
					continue;
				}else{
					// 条件
					
					empty($_POST['valid'][$key]) && $_POST['valid'][$key] = 0;
					empty($_POST['team'][$key]) && $_POST['team'][$key] = 0;
					empty($_POST['have'][$key]) && $_POST['have'][$key] = 0;
					// 权限
					empty($_POST['qrcode'][$key]) && $_POST['qrcode'][$key] = 0;
					empty($_POST['withdraw'][$key]) && $_POST['withdraw'][$key] = 0;
					empty($_POST['deposit'][$key]) && $_POST['deposit'][$key] = 0;
					empty($_POST['ground'][$key]) && $_POST['ground'][$key] = 0;
				}
				
				$config[] = array(
					'name' => $_POST['name'][$key],
					'valid' => $_POST['valid'][$key],
					'team' => $_POST['team'][$key],
					'have' => $_POST['have'][$key],
					'qrcode' => $_POST['qrcode'][$key],
					'withdraw' => $_POST['withdraw'][$key],
					'deposit' => $_POST['deposit'][$key],
					'ground' => $_POST['ground'][$key],
				);
			}
			
			unset($_POST);
			$_POST = $config;
			$this -> _save();
		}
		$this -> display();
	}
	
	// 轮播图设置
	public function banner(){
		if(IS_POST){
			$_POST['config'] = array();
			foreach($_POST['pic'] as $key => $val){
				$_POST['config'][] = array('pic' => $_POST['pic'][$key], 'url' => $_POST['url'][$key]);
			}
			unset($_POST['pic']);
			unset($_POST['url']);
		}
		$this -> _save();
		$this -> display();
	}
	
	// 标签设置
	public function feature(){
		if(IS_POST){
			
			$_POST['config'] = array();
			foreach($_POST['pic'] as $key => $val){
				$k = $key+1;
				$_POST['config'][$k] = array('pic' => $_POST['pic'][$key], 'name' => $_POST['name'][$key],'show' => $_POST['show'.$k],'checked' => $_POST['checked'.$k]);
				unset($_POST['show'.$k]);
				unset($_POST['checked'.$k]);
			}
			unset($_POST['pic']);
			unset($_POST['name']);	
			unset($_POST['checked']);			
		}
		//dump($this->_feature);
		$this -> _save();
		$this -> display();
	}
	
	// 顶部导航
	public function topcates(){
		if(IS_POST){
			$config = array();
			foreach($_POST['pic'] as $key => $val){
				$config[] = array('pic' => $_POST['pic'][$key], 'url' => $_POST['url'][$key],'title' => $_POST['title'][$key]);
			}
			$_POST = $config;
		}
		
		$this -> _save();
		$this -> display();
	}
	
	
	// 模板消息设置 => 初始化
	public function tplmsg(){
		$tplmsg = new \Common\Util\tplmsg();
		if(IS_POST){
			if($_POST['act'] == 'init'){
				$_POST = $tplmsg -> init();
				$this -> _save(false);
				if($_POST){
					$this -> success('成功获取了' .count($_POST). '个模板ID');
				}
				else{
					$this -> error(implode("\r\n",$tplmsg -> errmsg));
				}
				exit;
			}
			elseif($_POST['act'] == 'switch'){
				$GLOBALS['_CFG']['tplmsg'][$_POST['id']]['status'] = $_POST['status'] == 1 ? 1: 0;
				$_POST = $GLOBALS['_CFG']['tplmsg'];
				$this -> _save();
				$this -> success('操作成功！');
				exit;
			}
			
		}
		$this -> display();
	}
	
	
	//广告位设置
	public function ad(){
		if(IS_POST){
			$post = I('post.');
			if(M('ad')->where(array('title'=>$post['title']))->find()){
				M('ad')->where(array('title'=>$post['title']))->save(array(
					'pic'=>$post['pic'],
					'url'=>$post['url'],
				));
			}else{
				M('ad')->add(array(
					'title'=>$post['title'],
					'pic'=>$post['pic'],
					'url'=>$post['url'],
					'ad'=>substr($post['title'],-1,1),
				));
			}
			$this->success('操作成功');
			exit;
		}
		
		$this->display();
	}
	
	//初始化获取广告信息
	public function Ads(){
		$ads = M('ad')->order('ad asc')->select();
		if($ads && !empty($ads)){
			$this->success($ads);
		}else{
			$this->error('');
		}
	}
	
	//获取广告位信息
	public function getAd(){
		$title = I('post.title');
		$list = M('ad')->where(array('title'=>$title))->find();
		if($list){
			$this->success($list);
		}else{
			$this->error('');
		}
	}
	
	//团队奖设置
	public function tward(){
		if(IS_POST){
			$total = $_POST['total'];
			$config = array();
			foreach($_POST['level'] as $key => $val){
				$config[$val] = $_POST['rate'][$key];
			}
			unset($_POST['level']);
			unset($_POST['rate']);
			$_POST = $config;			
		}

		$this -> _save();
		$this->display();
	}
	
	private function _save($exit = true){
		// 通用配置保存操作
		if(IS_POST){
			// 有此配置则更新,没有则新增
			if(array_key_exists(ACTION_NAME, $this -> _CFG)){
				M('config') -> where(array('name' => ACTION_NAME)) -> save(array(
					'value' => serialize($_POST)
				));
			}else{
				M('config') -> add(array(
					'name' => ACTION_NAME,
					'value' => serialize($_POST)
				));
			}
			if($exit){
				$this -> success('操作成功！');
				exit;
			}
		}
	}

}?>
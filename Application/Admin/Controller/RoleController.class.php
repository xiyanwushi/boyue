<?php
namespace Admin\Controller;
use Think\Controller;
class RoleController extends AdminController {
	public function _initialize(){
		parent::_initialize();
	}
    public function index(){
		$this->assign('list',M('role')->order('sort desc,id asc')->select());
		$this->display();
    }
	
	public function edit(){
		if(IS_POST){
			if($_POST['id']){
				if(M('role')->where(array('id'=>$_POST['id']))->save($_POST)){
					$this->success('修改成功',U('index'));
				}else{
					$this->error('修改失败');
				}
			}else{
				if(M('role')->add($_POST)){
					$this->success('添加成功',U('index'));
				}else{
					$this->error('添加失败');
				}
			}
			exit;
		}else{
			$id = $_GET['id'];
			$this->assign('info',M('role')->find(intval($id)));
			$this->display();
		}
	}
	
	public function role(){
		if($_POST){
			if(empty($_POST['rule_ids'])){
				$this->error('请配置权限');
			}
			foreach($_POST['rule_ids'] as $v){
				$rules .=$v.',';
			}
			$rules = substr($rules,0,-1);
			M('role')->where(array('id'=>$_POST['role_id']))->save(array('rules'=>$rules));
			$this->success('操作成功');
			exit;
		}
		$this->assign('role_id',$_GET['id']);
		$this->display();
	}
	
	//获取角色MENU
	public function getMenu(){
	    $role_id = I('post.role_id');
        $role = M('role')->where(array('id'=>$role_id))->find();
        $rules= explode(',', $role['rules']);
        $menu = M('menu')->field('id,pid,name')->select();
        $list = list_to_tree($menu);
        $html = '';
        $html .= '<table class="table table-striped table-bordered table-hover table-condensed">';
        foreach($list as $k=>$v) {
            $html .= '<tr class="b-group">';
            //th
            $html .= '<th width="20%">';
            $html .= '<label>';
            if(in_array($v['id'],$rules)){
                $html .= '<input type="checkbox" name="rule_ids[]" value="'.$v['id'].'"" checked="checked" onclick="checkAll(this)" >'.$v['name'].'';
            }else{
                $html .= '<input type="checkbox" name="rule_ids[]" value="'.$v['id'].'""  onclick="checkAll(this)" >'.$v['name'].'';
            }
            $html .= '</label>';
            $html .= '</th>';
            // end th

            //td
            $html .= '<td class="b-child">';

                $html .= '<table class="table table-striped table-bordered table-hover ">' ;
                $html .= '<tr class="b-group">';
                foreach ($v['_child'] as $k => $c){
//                $html .= '<div>';
                $html .= '<div class="tab">';
                if(in_array($c['id'],$rules)) {
                    $html .= '<input type="checkbox" name="rule_ids[]" value="'.$c['id'].'" checked="checked">' . $c['name'] . '';
                }else{
                    $html .= '<input type="checkbox" name="rule_ids[]" value="'.$c['id'].'">' . $c['name'] . '';
                }
                $html .= '</div>';
//                $html .= '</div>';
                 }
                $html .= ' </tr>';
                $html .= ' </table>';


            $html .= '</td>';
            // end td

            $html .= '</tr>';

        }
        $html .= '</table>';
        $this->success($html);
    }
	
	// 删除订单
	public function del(){
		if(!IS_ADMIN){
			$this -> error('您无权删除订单');
		}
		M('role') -> delete(intval($_GET['id']));
		$this -> error('订单删除成功！',U('index'));
	}
	
	
	
}
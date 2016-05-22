<?php
/**
 * Created by PhpStorm.
 * User: Raven
 * Date: 2016/5/12
 * Time: 15:14
 */

namespace Common\Model;
use Think\Model;

/**
 * 文章内容Model操作
 *
 */
class NewsModel extends Model
{
    private $_db = '';

    public function __construct()
    {
        $this->_db = M("news");
    }

    public function insert ($data = array()){
        if(!is_array($data) || !$data){
            return 0;
        }

        $data['create_time'] = time();
        $data['username'] = getLoginUsername();

        return $this->_db->add($data);
    }

    public function getNews($data, $page, $pageSize = 10){
        $conditions = $data;
        if(isset($data['title']) && $data['title']){
            $conditions['title'] = array('like','%'.$data['title'].'%');
        }
        if(isset($data['catid']) && $data['catid']){
            $conditions ['catid'] = intval($data['catid']);
        }
        $conditions['status'] = array('neq', -1);

        $offset = ($page -1) * $pageSize;
        $list = $this->_db->where($conditions)
            ->order('listorder desc, news_id desc')
            ->limit($offset,$pageSize)
            ->select();

        return $list;
    }

    public function getNewsCount($data = array()){
        $conditions = $data;
        if(isset($data['title']) && $data['title']){
            $conditions['title'] = array('like','%'.$data['title'].'%');
        }
        if(isset($data['catid']) && $data['catid']){
            $conditions ['catid'] = intval($data['catid']);
        }

        return $this->_db->where($conditions)->count();
    }

    public function find($id){
        $data = $this->_db->where('news_id='.$id)->find();
        return $data;
    }

    public function updateById($id,$data){
        if(!$id || !is_numeric($id)){
            throw_exception("ID不合法");
        }
        if(!$data || !is_array($data)){
            throw_exception('更新数据不合法');
        }

        return $this->_db->where('news_id='.$id)->save($data);
    }

    //修改状态的方法
    public function updateStatusById($id,$status){
        if(!is_numeric($status)){
            throw_exception('status不能为非数字');
        }
        if(!$id || !is_numeric($id)){
            throw_exception('ID不合法');
        }
        $data['status'] = $status;

        return $this->_db->where("news_id=".$id)->save($data);
    }

    //文章管理页面更新排序功能
    public function updateListorderById($id,$listorder){
        if(!$id || !is_numeric($id)){
            throw_exception('ID不合法');
        }

        $data = array('listorder'=> intval($listorder));
        return $this->_db->where('news_id='.$id)->save($data);
    }

    //文章推荐位内容查询
    public function getNewsByNewsIdIn($newsIds){
        if (!is_array($newsIds)){
            throw_exception('参数不合法');
        }
        $data = array(
            'news_id' => array('in',implode(',',$newsIds)),
        );
        return $this->_db->where($data)->select();
    }
    //查询文章
    public function select($data,$limit=0){
        if ($data['title']){
            $data['title'] = array('like','%'.$data['title'].'%');
        }
        $this->_db->where($data)->order('listorder desc,news_id desc');
        if ($limit){
            $this->_db->limit($limit);
        }
        $list = $this->_db->select();

        return $list;
    }
    //获取排行的数据
    public function getRank($data=array(),$limit =100){
        $list = $this->_db->where($data)->order('count desc,news_id desc')->limit($limit)->select();
        return $list;
    }
    //更新文章阅读数
    public function updateCount($id,$count){
        if (!is_numeric($id) || !$id){
            throw_exception('ID不合法');
        }
        if (!is_numeric($count)){
            throw_exception('count不能为非数字');
        }
        $data['count'] = $count;
        return $this->_db->where("news_id=".$id)->save($data);
    }
    /**
     * 获取最大阅读数
     */
    public function maxCount(){
        $data = array(
            'status' => 1,
        );
        return $this->_db->where($data)->order('count desc')->limit(1)->find();
    }
}
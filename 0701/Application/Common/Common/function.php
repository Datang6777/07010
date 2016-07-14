<?php
function test()
{
    echo '<h1>WLECOME</h1>';
}


function tree($arr , $id = 'cid' , $pid = 'pid')
{
    $items = array();

    foreach($arr as $row)	//处理下标
    {
        $items[$row[$id]] = $row;
    }

    foreach($items as $item)
    {
        $items[$item[$pid]]['son'][$item[$id]] = &$items[$item[$id]];
        // arr[0][son][1] = arr[1]
        // 加引用复制是为了同步修改 $items , 否则son 就不会赋值到 $items里
    }
    return isset($items[0]['son']) ? $items[0]['son'] : array();
}

function formselect($arr , $pid = 0, $i = 0)
{
    static $html;
    foreach($arr as $val)
    {
        $selected = '';
        if($val['cid'] == $pid)
            $selected = 'selected';

        $html .= '<option value="'.$val['cid'].'" '.$selected.'>'.str_repeat('|-----' , $i).$val['cate_name'].'</option>';
        if(isset($val['son']))
        {
            formselect($val['son'],$pid, $i+1);
        }
    }
    return '<select name="pid"><option value="0">根分类</option>'.$html.'</select>';
}

function check($arr)
{
    foreach($arr as $k => &$v)
    {
        if(!is_array($v) && ($k != 'content'))
        {
            $v = htmlspecialchars($v);
        }
    }
    return $arr;
}

/*function redirect($url = '')
{
    header('Location:'.$url);
    exit();
}*/
// $html = '';
function getTree($arr , $i = 0)
{
    static $html;
    foreach($arr as $val)
    {
        $html .= '<li>'.str_repeat('|-----' , $i).$val['cate_name'].'<a href="cateMod.php?cid='.$val['cid'].'">修改</a></li>';
        if(isset($val['son']))
        {
            getTree($val['son'] , $i+1);
        }
    }
    return '<ul>'.$html.'</ul>';
}

function getTable($datas = array() , $fields = array() , $mod = array())
{
    $html = '<table>';
    $html .= '<tr>';
    foreach($fields as $field)
    {
        if(is_array($field))
        {
            $html .= '<th>'.$field['mc'].'</th>';
        }else{
            $html .= '<th>'.$field.'</th>';
        }
    }
    $html .= '<th>操作</th>';
    $html .= '</tr>';
    foreach($datas as $data)
    {
        $html .= '<tr>';
        foreach($data as $k => $val)
        {
            if(in_array($k , array_keys($fields))){
                if(is_array($fields[$k]))
                {
                    if($fields[$k]['type'] == 'time')
                    {
                        $html .= '<td>'.date( $fields[$k]['format'], $val ).'</td>';
                    }elseif($fields[$k]['type'] == 'title'){
                        $del = '';
                        if(mb_strlen($val , 'utf-8') > $fields[$k]['nums'])
                        {
                            $del = '...';
                        }

                        $html .= '<td>'.mb_substr( $val , 0 , $fields[$k]['nums'] , 'utf-8').$del.'</td>';
                    }else{
                        $html .= '<td>'.$fields[$k]['check'][$val].'</td>';
                    }


                }else{
                    $html .= '<td>'.$val.'</td>';
                }
            }
        }
        $html .= '<td>';
        foreach($mod as $m)
        {
            $html .='<a href="'.$m['url'].'?'.$m['field'].'='.$data[$m['field']].'">'.$m['mc'].'</a>';
        }

        $html .= '</td></tr>';
    }
    $html .= '</table>';

    return $html;
}


function getPageList($sql = '' ,  $fields = array() , $mod = array())
{
    // 1.总条数 count(总数据)
    // 2.每页条数 ,建议定义常量配置
    // 3.页数 ceil(总条数 / 每页条数)
    // 4.url  parse_url($_SERVER['REQUEST_URI']); 路径 , 参数
    // 5.当前页数 $_GET
    $count = count(DB($sql)); //获取总条数
    // PAGE_NUM
    $totalNum = ceil($count / PAGE_NUM); //获取总页数,进一法取整
    $request_url = parse_url($_SERVER['REQUEST_URI']);  //获取当前URL的数组 path 路径, query 参数
    $path = $request_url['path']; //获取path 路径部分

    $page = (isset($_GET['page']) && $_GET['page'] != '') ? $_GET['page'] : 1; //获取当前页

    $limit = ' LIMIT '.($page - 1) * PAGE_NUM.','.PAGE_NUM;  //组装limit 语句

    $datas = DB($sql . $limit); //执行SQL语句,获取数据数组

    $html = getTable($datas , $fields , $mod); //获取表格

    if($count < PAGE_NUM)
        return $html;

    $start = ($page - PAGE_OFFSET) > 0 ? $page - PAGE_OFFSET : 1; //获取左侧位置偏移
    $end = ($page + PAGE_OFFSET) < $totalNum ? $page + PAGE_OFFSET : $totalNum; //获取右侧位置偏移

    $html .= '<div class="page">';
    if($page > 1) //如果当前页大于1的时候,才显示上一页和首页
    {
        $html .= '<a href="'.$path.'?page='.($page - 1).'">上一页</a>';
        $html .= '<a href="'.$path.'?page=1">首页</a>';
    }
    for($i = $start ; $i <= $end ; $i++) //循环偏移量范围内的页数
    {
        $class = ($i == $page) ? 'class="on"' : ''; //如果是当前页,追加 on 样式
        $html .= '<a href="'.$path.'?page='.$i.'" '.$class.'>'.$i.'</a>';
    }

    if($page < $totalNum) //如果当前页小于总页数的时候,才显示下一页和尾页
    {
        $html .= '<a href="'.$path.'?page='.$totalNum.'">尾页</a>';
        $html .= '<a href="'.$path.'?page='.($page + 1).'">下一页</a>';
    }
    $html .= '共 '.$totalNum.' 页';
    $html .= '</div>';

    return $html;
}


function getTagsName($data = array())
{
    $html = '<select name="tags">';
    foreach($data as $d)
    {
        $html .= '<option value="'.$d['tid'].'">'.$d['tag_name'].'</option>';
    }
    $html .= '</select>';

    return $html;
}

//获取所有子栏目ID
function getChildIds($cid = '')
{
    static $list;
    $data = DB('SELECT cid FROM cate WHERE pid = '.$cid);
    foreach($data as $d)
    {
        $list[] = $d['cid'];
        getChildIds($d['cid']);
    }
    return $list;
}

function getSubTitle($str = '', $num = '25')
{
    if(mb_strlen($str , 'utf-8') > $num)
    {
        $str = '<td>'.mb_substr( $str , 0 , $num , 'utf-8').'...</td>';
    }
    return $str;
}
<?php
    function p($arr)
    {
        dump($arr,1,'<pre>',0);
    }
    function confirm($id)
    {
        if($id==0)$this->redirect('index');
        $flag =0;
        if($_SESSION['item'])
            {
               $item = $_SESSION['item'];
               $arr = explode('|',$item);
               foreach($arr as $i)
               {
                   if($i==$id)
                   $flag=1;
               }
            }
        else $this->redirect('index');
        if($flag==0)
            {
                $conditon['cid']=$id;
                $sql = M('contest');
                $res=$sql->where($conditon)->select();
                //dump($res);
                if($res[0]['password']==NULL&&$res[0]['private']==0);
                else $this->redirect('index');
            }
    }
    function getProblemsLength($pros)
    {
        return count($pros);
    }
    function getProblemIndex($pro,$pros)
    {
        for($i=0;$i<count($pros);$i++)
        {
            if($pros[$i]["pid"]==$pro)
                return $i;
        }
        return -1;
    }
    function dealRankData($rankdata,$time,$pros,$users)
    {
        $st_time = strtotime($time);
        $index=0;
        $length=getProblemsLength($pros);
        $fst_pass_time=array();
        $result=array();
        if(count($users)==0)
        {
            $result[0]["slv_problems"]=$length;
            $result[0]["goal_nth"]=-1;
            return $result;
        }
        //rankdata[0]['uid']
        //初始化题目通过时间列表-1代表此题无人通过
        for($i=0;$i<$length;$i++)
        {
            $fst_pass_time[$i]=array();
            $fst_pass_time[$i]["time"]=-1;
            $fst_pass_time[$i]["id"]="";
        }
        $travel_num=0;
        //初始化所有结果
        for($i=0;$i<count($users);$i++)
        {
            $result[$i]=array();
            $result[$i]["pa_id"]=$users[$i]["pa_id"];
            $result[$i]["pa_name"]=$users[$i]["pa_name"];
            if($result[$i]["pa_name"][0]=='*')
            {
                $result[$i]["is_travel"]=1;
                $travel_num++;
            }
            else
                $result[$i]["is_travel"]=0;
            $result[$i]["tot_time"]=0;
            $result[$i]["slv_problems"]=0;
            $result[$i]["is_update"]=0;
            $result[$i]["goal_nth"]=4;
            $result[$i]["try_problems"]=array();
            $result[$i]["pass_time"]=array();
            $result[$i]["is_first"]=array();
            for($j=0;$j<$length;$j++)
            {
                $result[$i]["try_problems"][$j]=0;
                $result[$i]["pass_time"][$j]=0;
                $result[$i]["is_first"][$j]=0;
            }
        }

        //处理排名信息
        //echo "Count". count($rankdata);
        for($i=0;$i<count($rankdata);$i++)
        {
            if($result[$index]["pa_id"]==$rankdata[$i]["pa_id"])
            {
                $pro_nth=getProblemIndex($rankdata[$i]["pid"],$pros);
                //处理题目被删情况
                if($pro_nth==-1)
                    continue;
                //处理AC后提交代码情况
                if($result[$index]["pass_time"][$pro_nth]!=0)
                    continue;
                //标记有提交情况
                $result[$index]["is_update"]=1;

                //处理AC
                if($rankdata[$i]["result"]==4)
                {
                   $solved_time=strtotime($rankdata[$i]["create_time"])-$st_time;
                   $result[$index]["pass_time"][$pro_nth]=$solved_time;
                   //处理总题数增加和时间增加
                   $result[$index]["tot_time"]+=$solved_time+$result[$index]["try_problems"][$pro_nth]*1200;
                   $result[$index]["slv_problems"]++;
                   //echo "First ".$fst_pass_time[$pro_nth]."<br />";
                   //记录first ac
                   if($fst_pass_time[$pro_nth]["time"]==-1||$fst_pass_time[$pro_nth]["time"]>$solved_time)
                   {
                      $fst_pass_time[$pro_nth]["time"]=$solved_time;
                      $fst_pass_time[$pro_nth]["id"]=$rankdata[$i]["pa_id"];
                   }
                }
                else
                //处理其它情况
                {
                    $result[$index]["try_problems"][$pro_nth]++;
                }
            }    
            else
            {
                $index++;
                $i--;
            }        
        }

        //echo "End".$index;
        //标记first blood
        for($i=0;$i<$length;$i++)
        {
            if($fst_pass_time[$i]["time"]==-1)
                continue;
            for($j=0;$j<=$index;$j++)
            {
                if($result[$j]["pa_id"]==$fst_pass_time[$i]["id"])
                {
                    $result[$j]["is_first"][$i]=1;
                    break;
                }
            }
        }
        usort($result,'sortRank');
        //处理所属奖范围 1代表金牌，2代表银牌，3代表铜牌，4代表铁牌
        $gold_num=ceil(count($users)*0.1);
        $silver_nth=ceil(count($users)*0.2);
        $bronze_num=ceil(count($users)*0.3);
        
 
        $cnt=0;
        $now_goal=1;$rank=1;
        for($i=0;$i<=$index;$i++)
        {
            //echo "TellS ".+$i." ".$now_goal." "."<br />";
            $result[$i]["goal_nth"]=$now_goal;
            $result[$i]['id']=$i+1;
            if($result[$i]["is_travel"]==1)
                continue;
            $cnt++;
            $result[$i]['rank']=$rank++;
            if($now_goal==1)
            {
                if($cnt==$gold_num)
                {
                    $now_goal++;
                    $cnt=0;
                }
            }
            else if($now_goal==2)
            {
                if($cnt==$silver_nth)
                {
                    $now_goal++;
                    $cnt=0;
                }
            }
            else if($now_goal==3)
            {
                if($cnt==$bronze_num)
                {
                    $now_goal++;
                    $cnt=0;
                }
            }
        }
        return $result;
    }
    function sortRank($a,$b)
    {
        if($a["slv_problems"]>$b["slv_problems"])
        {
            return -1;
        }
        else if($a["slv_problems"]==$b["slv_problems"]&&$a["tot_time"]<$b["tot_time"])
        {
            return -1;
        }
        else if($a["slv_problems"]==$b["slv_problems"]&&$a["tot_time"]==$b["tot_time"]&&
        $a["is_update"]>$b["is_update"])
        {
            return -1;
        }
        else if($a["slv_problems"]==$b["slv_problems"]&&$a["tot_time"]==$b["tot_time"]&&
        $a["is_update"]==$b["is_update"]&&$a["pa_name"]<=$b["pa_name"])
        {
            return -1;   
        }
        return 1;
    }
?>


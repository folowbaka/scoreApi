<?php
/**
 * Created by IntelliJ IDEA.
 * User: david
 * Date: 14/06/2018
 * Time: 00:32
 */

namespace App\Modele;


class Vote
{

    public static function rating_bar($vote, $units='', $static='') {

        //set some variables
        $rating_unitwidth = 30;
        if (!$units) {$units = 5;}
        if (!$static) {$static = FALSE;}
        $pageSlug=$vote->getPageSlug();
        // get votes, values, ips for the current rating bar


        if ($vote->getTotalVotes()<1) { $count = 0; }
        else { $count=$vote->getTotalVotes(); }

        $current_rating=$vote->getTotalValue(); //total number of rating added together and stored
        $tense=($count==1) ? "vote" : "votes"; //plural form votes/vote

        // determine whether the user has voted, so we know how to draw the ul/li
        //$req = DB::getInstance()->query("SELECT used_ips FROM ratings WHERE used_ips LIKE '%".$ip."%' AND page_id='".$page_id."'");
        //$voted = $req->rowCount();

        // now draw the rating bar

        if($count>0)
        {
            $rating_width = @number_format($current_rating/$count,2)*$rating_unitwidth;
            $rating1 = @number_format($current_rating/$count,1);
            $rating2 = @number_format($current_rating/$count,2);
        }
        else
        {
            $rating_width = 0;
            $rating1 = 0;
            $rating2 = 0;
        }

        if ($static == 'static') {

            $static_rater = array();
            $static_rater[] .= "\n".'<div class="ratingblock">';
            $static_rater[] .= '<div id="unit_long'.$pageSlug.'">';
            $static_rater[] .= '<ul id="unit_ul'.$pageSlug.'" class="unit-rating" style="width:'.$rating_unitwidth*$units.'px;">';
            $static_rater[] .= '<li class="current-rating" style="width:'.$rating_width.'px;">Currently '.$rating2.'/'.$units.'</li>';
            $static_rater[] .= '</ul>';
            $static_rater[] .= '<p class="static"><strong> '.$rating1.'</strong>/'.$units.' ('.$count.' '.$tense.' ) <em>This is \'static\'.</em></p>';
            $static_rater[] .= '</div>';
            $static_rater[] .= '</div>'."\n\n";

            return join("\n", $static_rater);
        }
        else {

            $rater ='';
            $rater.='<div class="ratingblock">';
            $rater.='<div id="unit_long'.$pageSlug.'">';
            $rater.='<ul id="unit_ul'.$pageSlug.'" class="unit-rating" style="width:'.$rating_unitwidth*$units.'px;">';
            $rater.='<li class="current-rating" style="width:'.$rating_width.'px;">Currently '.$rating2.'/'.$units.'</li>';

            $voted=false;
            for ($ncount = 1; $ncount <= $units; $ncount++) { // loop from 1 to the number of units
                if(!$voted) { // if the user hasn't yet voted, draw the voting stars
                    $rater.='<li><a href="/vote/vote/db.php?j='.$ncount.'&amp;q='.$pageSlug.'&amp;c='.$units.'" title="'.$ncount.' sur '.$units.'" class="r'.$ncount.'-unit rater" rel="nofollow">'.$ncount.'</a></li>';
                }
            }

            $ncount=0; // resets the count

            $rater.='  </ul>';
            $rater.='  <p';
            if($voted){ $rater.=' class="voted"'; }
            $rater.='><strong> '.$rating1.'</strong>/'.$units.' ('.$count.' '.$tense.')';
            $rater.='  </p>';
            $rater.='</div>';
            $rater.='</div>';

            return $rater;
        }
    }
}
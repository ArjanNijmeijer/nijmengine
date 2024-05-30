<?php
$api = new DataserviceApi();

$matches = $api->getMatches( 0 );
$playedMatches = $api->getMatchesResults();

$matches = array_merge($playedMatches, $matches);

$dates = array();
$dateLabel = array();

$dateNames = array(
    '01' => 'Januari',
    '02' => 'Februari',
    '03' => 'Maart',
    '04' => 'April',
    '05' => 'Mei',
    '06' => 'Juni',
    '07' => 'Juli',
    '08' => 'Augustus',
    '09' => 'September',
    '10' => 'Oktober',
    '11' => 'November',
    '12' => 'December'
);

$dayNames = array(
    1 => 'Maandag',
    2 => 'Dinsdag',
    3 => 'Woensdag',
    4 => 'Donderdag',
    5 => 'Vrijdag',
    6 => 'Zaterdag',
    7 => 'Zondag'
);

foreach( $matches AS $match)
{
    $dateParts = explode('T', $match->wedstrijddatum );
    $dateParts = explode('-', $dateParts[0] );

    $dateKey = $dateParts[0].$dateParts[1].$dateParts[2];

    if( strpos( strtolower( $match->thuisteam ), 'stadskanaal') !== false )
    {
        $key = 'home';
    }
    else
    {
        $key = 'out';
    }

    $dates[$dateKey][$key][$match->wedstrijdcode] = $match;

    $theDate = strtotime( $match->wedstrijddatum );
    $dayNumberInWeek = date('N', $theDate );
    $dateLabel[$dateKey] = $dayNames[$dayNumberInWeek].' '.$dateParts[2].' '.$dateNames[$dateParts[1]].' '.$dateParts[0];
}

ksort($dates);

$teams = $api->getTeams('RN');

$theTeams = array();
foreach( $teams AS $team )
{
    $theTeams[ 'v-' . $team->teamcode ] = $team->teamnaam;
}
?>
<style>
    th{ background:#EFC10D; color:#FFF;}
    td,th{ padding:4px; }
    .odd{ background:#F1F1F1; }

</style>
<div style="float:right; ">
    Zoek op elftal:
    <select onchange="jQuery('#program tr').hide(); jQuery('#program .hideMe').hide(); jQuery('#program .'+jQuery('#selectedTeam').val() ).show(); jQuery('#program tr.'+jQuery('#selectedTeam').val() ).show();" id="selectedTeam">
        <option value="all">Toon alles</option>
        <?php foreach( $theTeams AS $teamId => $teamName){ ?>
            <option value="<?php echo $teamId; ?>"><?php echo $teamName; ?></option>
        <?php } ?>
    </select>
</div>

<div id="program">
    <h2 class="postTitle">Programma</h2>
    <?php foreach($dates AS $key => $dateMatches){

        $searchHomeClass = '';
        if( isset( $dateMatches['home'] ) ){
            foreach( $dateMatches['home'] AS $match ) {
                $classHome = 'v-' . $match->thuisteamid;
                $classOut = 'v-' . $match->uitteamid;
                $searchHomeClass .= ' '.$classHome.' '.$classOut.' ';
            }
        }

        $searchOutClass = '';
        if( isset( $dateMatches['out'] ) ){
            foreach( $dateMatches['out'] AS $match ) {
                $classHome = 'v-' . $match->thuisteamid;
                $classOut = 'v-' . $match->uitteamid;
                $searchOutClass .= ' '.$classHome.' '.$classOut.' ';
            }
        }
        ?>
        <h3 class="all <?php echo $searchHomeClass. ' ' .$searchOutClass; ?> hideMe"><?php echo $dateLabel[$key]; ?></h3>

        <h4 class="all <?php echo $searchHomeClass; ?> hideMe">Thuis wedstrijden</h4>
        <?php
        $counter = 0;
        if( isset( $dateMatches['home'] ) ){ ?>
            <table class="all <?php echo $searchHomeClass; ?> hideMe" style="width:100%;">
                <?php foreach( $dateMatches['home'] AS $match ) {
                    $classHome = 'v-' . $match->thuisteamid;
                    $classOut = 'v-' . $match->uitteamid;
                    ?>
                    <tr class="all <?php echo ( $counter % 2 == 0 ? 'even' : 'odd'); ?> <?php echo $classOut.' '.$classHome; ?>" >
                        <td class="cell_team">
                            <img src="https://logoapi.voetbal.nl/logo.php?clubcode=<?php echo $match->thuisteamclubrelatiecode; ?>" style="margin-right:10px; width:20px;" />
                            <?php echo $match->thuisteam; ?>
                        </td>
                        <td style="width:1%;">-</td>
                        <td class="cell_team" style="text-align: right;">
                            <?php echo $match->uitteam; ?>
                            <img src="https://logoapi.voetbal.nl/logo.php?clubcode=<?php echo $match->uitteamclubrelatiecode; ?>" style="margin-left:10px; width:20px;" />
                        </td>
                        <td class="cell_accomodatie" style="text-align:right;"><?php echo $match->accommodatie; ?></td>
                        <td style="text-align:right;width:14%;">
                            <?php
                            $dateParts = explode('T', $match->wedstrijddatum );
                            $dateParts = explode('-', $dateParts[0] );

                            $dateKey = $dateParts[0].$dateParts[1].$dateParts[2];
                            $dateCheck = date('Ymd');
                            if((isset($match->status)) && (strpos(strtolower($match->status),'afgelast') !== false)){
                                echo 'AFG';
                            }else if(isset($match->uitslag)){
                                echo trim($match->uitslag) == '-' ? 'AFG' : $match->uitslag;
                            } else {
                                echo 'aanv. '.$match->aanvangstijd.' uur';
                            }
                            ?>
                        </td>
                    </tr>
                    <?php $counter++;  } ?>
            </table>
        <?php }else{ ?>
            <div style="margin-bottom:1em"><em class="hideMe" style="margin-bottom:1em">momenteel nog geen geplande thuiswedstrijden</em></div>
        <?php } ?>

        <h4 class="all <?php echo $searchOutClass; ?> hideMe">Uit wedstrijden</h4>
        <?php
        $counter = 0;
        if( isset( $dateMatches['out'] ) ){ ?>
            <table class="all <?php echo $searchOutClass; ?> hideMe" style="width:100%;">
                <?php foreach( $dateMatches['out'] AS $match ) {
                    $classHome = 'v-' . $match->thuisteamid;
                    $classOut = 'v-' . $match->uitteamid;

                    ?>
                    <tr class="all <?php echo ($counter % 2 === 0 ? 'even' : 'odd'); ?> <?php echo $classOut.' '.$classHome; ?>" >
                        <td class="cell_team">
                            <img src="https://logoapi.voetbal.nl/logo.php?clubcode=<?php echo $match->thuisteamclubrelatiecode; ?>" style="margin-right:10px; width:20px;" />
                            <?php echo $match->thuisteam; ?>
                        </td>
                        <td style="width:1%;">-</td>
                        <td class="cell_team" style="text-align: right;">
                            <?php echo $match->uitteam; ?>
                            <img src="https://logoapi.voetbal.nl/logo.php?clubcode=<?php echo $match->uitteamclubrelatiecode; ?>" style="margin-left:10px; width:20px;" />
                        </td>
                        <td class="cell_accomodatie" style="text-align:right;"><?php echo $match->accommodatie; ?></td>
                        <td style="text-align:right;width:14%;">
                            <?php
                            $dateParts = explode('T', $match->wedstrijddatum );
                            $dateParts = explode('-', $dateParts[0] );

                            $dateKey = $dateParts[0].$dateParts[1].$dateParts[2];
                            $dateCheck = date('Ymd');

                            if((isset($match->status)) && (strpos(strtolower($match->status),'afgelast') !== false)){
                                echo 'AFG';
                            }else if(isset($match->uitslag)){
                                echo trim($match->uitslag) == '-' ? 'AFG' : $match->uitslag;
                            } else {
                                echo 'aanv. '.$match->aanvangstijd.' uur';
                            }
                            ?>
                        </td>
                    </tr>
                    <?php $counter++; } ?>
            </table>
        <?php }else{ ?>
            <div style="margin-bottom:1em"><em class="hideMe" >momenteel nog geen geplande uitwedstrijden</em></div
        <?php }
    } ?>
</div>

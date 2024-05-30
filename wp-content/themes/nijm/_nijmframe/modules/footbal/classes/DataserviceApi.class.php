<?php
/**
 * PHP Class for the KNVB DataService API
 *
 *
 *
 * @copyright  2017 Nijm Webdesign & Hosting
 * @license    none yet
 * @version    Release: 2.0.0
 * @link       https://nijm.nl
 * @since      Class available since Release 1.0.0
 *https://dexels.github.io/navajofeeds-json-parser/
 * @Documentation
 */

class DataserviceApi
{
    private $clientId;
    private $url = 'https://data.sportlink.com';
    private $cache;

    private $comptypes = array();

    /**
     * Instantiate the api and retrieve a sessionId
     *
     * @param  String	$clientId, The unique path given by the KNVB
     */
    public function __construct( $clientId = 'lBeAhSolf0' )
    {
        $this->clientId = $clientId;

        $this->comptypes = array(
            'A',  // Alles
            'B',  // Beker
            'R',  // Regulier
            'RN', // Regulier + nacompetitie
            'N',  // Na competitie
            'V',  // WORDT NIET MEER GEBRUIKT WAS VOORHEEN VRIENDSCHAPPELIJK!
        );
    }

    /**
     * Return all teams
     *
     * @param  $comptype teams from specific competition
     * @throws Exception If no data could be found
     * @return Array with team information
     */
    public function getTeams( $comptype = 'A'  )
    {
        $getVars = '';

        if( in_array( strtoupper( $comptype ),  $this->comptypes ) )
        {
            $comptype = $this->translateCompType( $comptype );

            $getVars .= '&competitiesoort='.$comptype;
        }

        return $this->getResults( $this->url.'/teams?client_id=' . $this->clientId . $getVars );
    }

    /**
     * Return all teams
     *
     * @param  $teamName the name of the team but teamcode is also allowed
     * @throws Exception If no data could be found
     * @return Array with team information
     */
    public function getTeam( $teamCode = '', $comptype = 'A' )
    {
        $results = array();

        $teams = $this->getTeams( $comptype );

        foreach( $teams AS $team )
        {
			if( (int) $teamCode === (int) $team->teamcode ) {
                $results[] = $team;
            }
        }


        return $results;
    }

    /**
     * Gives all scheduled matches
     *
     * @param  integer	$teamid
     * @param  integer	$weekNumber OPTIONAL weeknumber offset from week of now, default 1 week later
     * @param  char	$comptype	OPTIONAL type of match: R = 'R', 'B', 'N', 'V'
     * @throws Exception or false if error or nothing found
     * @return StdClass with matchinfo
     */
    public function getTeamSchedule( $teamId = '', $weekNumber = 1, $comptype = '', $nrOfdays = 7 )
    {
        $getVars = '';

        if( $teamId )
        {
            $getVars = '&teamcode=' . $teamId;
        }

        if(($weekNumber > 0 && $weekNumber < 54) || strtoupper( $weekNumber ) === 'A')
        {
            $getVars .= '&weekoffset='.$weekNumber;
        }

        if( $nrOfdays > 0 )
        {
            $getVars .= '&aantaldagen='.$nrOfdays;
        }

        if( in_array( strtoupper( $comptype ),  $this->comptypes ) )
        {
            $comptype = $this->translateCompType( $comptype );

            $getVars .= '&competitiesoort='.$comptype;
        }

        return $this->getResults( $this->url.'/programma?client_id=' . $this->clientId.$getVars );
    }

    /**
     * Gives all matchdata from results
     *
     * @param  integer	$teamid
     * @param  integer	$weekNumber OPTIONAL weeknumber of the match you want, all = A
     * @param  char	$comptype	OPTIONAL type of match: R = 'R', 'B', 'N', 'V'
     * @throws Exception or false if error or nothing found
     * @return StdClass with matchinfo
     */
    public function getTeamResults( $teamId, $weekNumber = '', $comptype = '', $nrOfdays = 7 )
    {

        $getVars = '';

        if( $teamId )
        {
            $getVars = '&teamcode=' . $teamId;
        }

        if(($weekNumber > 0 && $weekNumber < 54) || strtoupper( $weekNumber ) === 'A')
        {
            $getVars .= '&weekoffset='.$weekNumber;
        }

        if( $nrOfdays > 0 )
        {
            $getVars .= '&aantaldagen='.$nrOfdays;
        }

        if( in_array( strtoupper( $comptype ),  $this->comptypes ) )
        {
            $comptype = $this->translateCompType( $comptype );

            $getVars .= '&competitiesoort='.$comptype;
        }

        return $this->getResults( $this->url.'/uitslagen?client_id=' . $this->clientId.$getVars );
    }

    /**
     * Gives the ranking
     *
     * @param  integer	$teamid
     * @param  char	$comptype	OPTIONAL type of match: R, B, N of V.
     * @throws Exception or false if error or nothing found
     * @return StdClass with the ranking
     */
    public function getTeamRanking( $teamId, $comptype = 'R' )
    {
        if(!$teamId)
        {
            throw new Exception('Errorcode: getTeamRanking -> geen geldig teamid');
        }

        $team = $this->getTeam( $teamId, $comptype );

		$filtered = array();
		foreach( $team AS $team )
		{
			if( strlen( $team->poulecode ) > 0 ){
				$filtered[] = $team;
			}
		}

        $team = end( $filtered );
	
        return $this->getResults( $this->url.'/poulestand?client_id=' . $this->clientId.'&poulecode=' . $team->poulecode );
    }


   /**
     * Get competition
     *
     * @param  integer	$teamid
     * @param  char	$comptype	OPTIONAL type of match: R, B, N of V.
     * @throws Exception or false if error or nothing found
     * @return StdClass with the competition
     */
    public function getCompetitionResult( $teamId, $comptype = 'R', $nrOfDays = 30, $showAll = true  )
    {
        if( !$teamId ) {
            throw new Exception('Errorcode: getTeamRanking -> geen geldig teamid');
        }

        $team = $this->getTeam( $teamId, $comptype );
		
		$filtered = array();
		foreach( $team AS $team )
		{
			if( strlen( $team->poulecode ) > 0 ){
				$filtered[] = $team;
			}
		}

		
        $team = end( $filtered );

        $getVars = '&poulecode=' . $team->poulecode . '&eigenwedstrijden=' .( $showAll ? 'NEE' : 'JA' ) .'&aantaldagen='.$nrOfDays;

        return $this->getResults( $this->url.'/pouleuitslagen?client_id=' . $this->clientId . $getVars );
    }

    /**
     * Get competition
     *
     * @param  integer	$teamid
     * @param  char	$comptype	OPTIONAL type of match: R, B, N of V.
     * @throws Exception or false if error or nothing found
     * @return StdClass with the competition
     */
    public function getCompetitionSchedule( $teamId, $comptype = 'R' , $nrOfDays = 30, $showAll = true )
    {
        if(!$teamId)
        {
            throw new Exception('Errorcode: getTeamRanking -> geen geldig teamid');
        }

        $team = $this->getTeam( $teamId, $comptype);
		
		$filtered = array();
		foreach( $team AS $team )
		{
			if( strlen( $team->poulecode ) > 0 ){
				$filtered[] = $team;
			}
		}

		
        $team = end( $filtered );
		
		

        $getVars = '&poulecode=' . $team->poulecode . '&eigenwedstrijden=' .( $showAll ? 'NEE' : 'JA' ) .'&aantaldagen='.$nrOfDays;

        if( in_array( strtoupper( $comptype ),  $this->comptypes ) )
        {
            $comptype = $this->translateCompType( $comptype );

            $getVars .= '&competitiesoort='.$comptype;
        }

        return $this->getResults( $this->url.'/poule-programma?client_id=' . $this->clientId . $getVars );
    }

    /**
     * Gives the ranking
     *
     * @param  integer	$teamid
     * @param  integer	$weeknumber OPTIONAL weeknumber of the matches you want, or A for ALL
     * @param  char	$comptype	OPTIONAL type of match: R, B, N of V.
     * @throws Exception or false if error or nothing found
     * @return StdClass with the ranking
     */
    public function getMatches( $weekNumber = '', $comptype = 'A', $nrOfdays = 50 )
    {
        $getVars = '';

        if( $weekNumber )
        {
            $getVars .= '&weekoffset='.$weekNumber;
        }

        if( $nrOfdays > 0 )
        {
            $getVars .= '&aantaldagen='.$nrOfdays;
        }

        if( in_array( strtoupper( $comptype ),  $this->comptypes ) )
        {
            $comptype = $this->translateCompType( $comptype );

            $getVars .= '&competitiesoort='.$comptype;
        }

        return $this->getResults( $this->url.'/programma?client_id=' . $this->clientId . $getVars );
    }
	
	public function getMatchesResults( $weekNumber = '', $comptype = 'A', $nrOfdays = 50 )
    {
        $getVars = '';

        if( $weekNumber )
        {
            $getVars .= '&weekoffset='.$weekNumber;
        }

        if( $nrOfdays > 0 )
        {
            $getVars .= '&aantaldagen='.$nrOfdays;
        }

        if( in_array( strtoupper( $comptype ),  $this->comptypes ) )
        {
            $comptype = $this->translateCompType( $comptype );

            $getVars .= '&competitiesoort='.$comptype;
        }

        return $this->getResults( $this->url.'/uitslagen?client_id=' . $this->clientId . $getVars );
    }

    /**
     * Gives the activities
     *
     * @param  integer	nrOfdays OPTIONAL number of days
     * @throws Exception or false if error or nothing found
     * @return array with activities
     */
    public function getActivities($nrOfdays = 7)
    {
        $getVars = '&aantaldagen='.$nrOfdays;
        return $this->getResults( $this->url.'/verenigingsactiviteiten?client_id=' . $this->clientId . $getVars );
    }

    /**
     * Gives the birthdays
     *
     * @param  integer	nrOfdays OPTIONAL number of days
     * @throws Exception or false if error or nothing found
     * @return array with activities
     */
    public function getBirthdays($nrOfdays = 21)
    {
        $getVars = '&aantaldagen='.$nrOfdays;
        return $this->getResults( $this->url.'/verjaardagen?client_id=' . $this->clientId . $getVars );
    }

    /**
     * Translates old values to the newer ones for backwards compatibility
     *
     * @param  char	$comptype	OPTIONAL type of match: R, B, N of V.
     * @return String $comptype
     */
    private function translateCompType( $comptype ){
        if( $comptype == 'R' ){
            $comptype = 'regulier';
        }else if( $comptype == 'B' ){
            $comptype = 'beker';
        }else if( $comptype == 'N' ){
            $comptype = 'nacompetitie';
        }else if( $comptype == 'RN' ){
            $comptype = 'regulier_nacompetitie';
        }else{
            $comptype = 'alles';
        }

        return $comptype;
    }



    private function getResults( $url ){

        if( isset( $this->cache[ md5( $url ) ] ) )
        {
           return $this->cache[ md5( $url ) ];
        }

        $jsonString = file_get_contents( $url );
        $result = json_decode( $jsonString );
        $this->cache[ md5( $url ) ] = $result;

        return $result;
    }
}
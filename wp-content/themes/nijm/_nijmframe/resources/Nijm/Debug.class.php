<?php
/*
 * The main template class with the most common functions.
 */

class Debug 
{	
	/**
     * Debug function, debugs the variable to the screen
     */
    public function show( $var, $return = false )
    { 
    	if( $return )
			return '<pre>'."\n".print_r($var, true).'</pre>'."\n";
		else
			echo '<pre>'."\n".print_r($var, true).'</pre>'."\n";		
	} 
	
	/* 
	 * Remove comments tabs, spaces, newlines, etc..
	 */
	public function compress( $buffer ) 
	{
		$buffer = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer );
		$buffer = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer );
		return $buffer;
	}
}
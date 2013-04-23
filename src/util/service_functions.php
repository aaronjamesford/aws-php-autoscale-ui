<?php

function get_json_body( ) {
	$contents = file_get_contents( "php://input" );
	$type = false;
	if( isset( $_SERVER[ "CONTENT_TYPE" ] ) ) {
		$type = $_SERVER[ "CONTENT_TYPE" ];
	}

	if( $contents == null || !$type || $type != "application/json" ) {
		// unsupported type
		return false;
	}

	return json_decode( $contents, true );
}

function set_allowed_header( $allowed ) {
	$list = implode( ", ", $allowed );
	$allow = "Allow: " . $list;

	header( $allow );
}

?>
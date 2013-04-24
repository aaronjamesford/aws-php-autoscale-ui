<?php

require_once( "../vendor/autoload.php" );
require_once( "../util/service_functions.php" );

require_once( "../config/aws_credentials.php" );

use Aws\AutoScaling\AutoScalingClient;

function extract_important( $policy ) {
	$response = array( );

	$response[ "AutoScalingGroupName" ] = $policy[ "AutoScalingGroupName" ];
	$response[ "PolicyName" ] = $policy[ "PolicyName" ];
	$response[ "ScalingAdjustment" ] = $policy[ "ScalingAdjustment" ];
	$response[ "AdjustmentType" ] = $policy[ "AdjustmentType" ];
	$response[ "Cooldown" ] = $policy[ "Cooldown" ];
	$response[ "PolicyARN" ] = $policy[ "PolicyARN" ];

	return $response;
}

function get_scaling_policy( $aws_credentials ) {
	$response = array( );

	$as_client = AutoScalingClient::factory( $aws_credentials );
	$model = $as_client->describePolicies( );
	$policies = $model->get( "ScalingPolicies" );

	$important = array( );
	foreach( $policies as $policy ) {
		$important[] = extract_important( $policy );
	}

	$response[ "ScalingPolicies" ] = $important;
	return json_encode( $response );
}

function put_scaling_policy( $aws_credentials ) {
	$args = get_json_body( );
	if( $args === false ) {
		http_response_code( 400 ); // bad request
		return "{}";
	}

	if( !isset( $args[ "PolicyName" ] ) || !isset( $args[ "AutoScalingGroupName" ] )
		 || !isset( $args[ "ScalingAdjustment" ] ) || !isset( $args[ "AdjustmentType" ] ) ) {
		http_response_code( 400 ); // bad request
		return "{}";
	}

	$as_client = AutoScalingClient::factory( $aws_credentials );
	$as_client->putScalingPolicy( $args );

	return "{}";
}

function delete_scaling_policy( $aws_credentials ) {
	if( !isset( $_REQUEST[ "PolicyName" ] ) || !isset( $_REQUEST[ "AutoScalingGroupName" ] ) ) {
		http_response_code( 400 ); // bad request
		return "{}";
	}

	$args = array(
		"PolicyName" => $_REQUEST[ "PolicyName" ],
		"AutoScalingGroupName" => $_REQUEST[ "AutoScalingGroupName" ]
	);

	$as_client = AutoScalingClient::factory( $aws_credentials );
	$as_client->deletePolicy( $args );

	return "{}";
}

$allowed = array( "GET", "PUT", "DELETE" );

$response = "";
switch ( $_SERVER[ "REQUEST_METHOD" ] ) {
	case 'GET':
		$response = get_scaling_policy( $aws_credentials );
		break;
	case "PUT":
		$response = put_scaling_policy( $aws_credentials );
		break;
	case "DELETE":
		$response = delete_scaling_policy( $aws_credentials );
		break;
	default:
		http_response_code( 405 ); // Method not allowed
		set_allowed_header( $allowed );
		$response = method_not_supported( );
		break;
}

header('Content-type: application/json');
echo $response;

?>
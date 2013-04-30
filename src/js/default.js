var ARNSource = new Array( );
var ARNMap = {};
var ComparisonOperators;
var StatisticValues;
var UnitValues;
var AutoScalingGroups;
var Metrics;

function getLaunchConfigurations( ) {
	$.ajax( {
		method : "GET",
		url : "aws/LaunchConfig.php",
		dataType : "json",
		success : function( json ) {
			$( "#LaunchConfigurationTable tbody" ).html( "" );

			var configs = json.LaunchConfigurations;
			if( configs != undefined && configs.length > 0 ) {
				for( var i = 0; i < configs.length; ++i ) {
					var row = $( "<tr></tr>" );
					row.append( $( "<td></td>" ).html( configs[ i ].LaunchConfigurationName ) );
					row.append( $( "<td></td>" ).html( configs[ i ].ImageId ) );
					row.append( $( "<td></td>" ).html( configs[ i ].InstanceType ) );
					row.append( $( "<td></td>" ).html( "<a href=\"#\" role=\"button\" class=\"btn btn-danger delete-btn\" data-launchconfigurationname=\"" + configs[ i ].LaunchConfigurationName + "\" >Delete</a>" ) );

					$( "#LaunchConfigurationTable tbody" ).append( row );
				}

				$( ".delete-btn" ).click( function( ) {
		          	deleteLaunchConfiguration( $( this ).data( "launchconfigurationname" ) );
		          	return false;
		        } );
			} else {
				var row = $( "<tr></tr>" );

				row.append( $( "<td></td>" ).html( "None" ) );
				row.append( $( "<td></td>" ).html( "None" ) );
				row.append( $( "<td></td>" ).html( "None" ) );
				row.append( $( "<td></td>" ).html( "None" ) );

				$( "#LaunchConfigurationTable tbody" ).append( row );
			}
		}
	} );
}

function getAutoScalingGroups( ) {
	$.ajax( {
		method : "GET",
		url : "aws/AutoScalingGroup.php",
		dataType : "json",
		success : function( json ) {
			$( "#AutoScaleGroupTable tbody" ).html( "" );

			var configs = json.AutoScalingGroups;
			if( configs != undefined && configs.length > 0 ) {
				for( var i = 0; i < configs.length; ++i ) {
					var row = $( "<tr></tr>" );
					row.append( $( "<td></td>" ).html( configs[ i ].AutoScalingGroupName ) );
					row.append( $( "<td></td>" ).html( configs[ i ].LaunchConfigurationName ) );
					row.append( $( "<td></td>" ).html( configs[ i ].MinSize ) );
					row.append( $( "<td></td>" ).html( configs[ i ].MaxSize ) );
					row.append( $( "<td></td>" ).html( "<a href=\"#\" role=\"button\" class=\"btn btn-danger delete-btn\" data-autoscalename=\"" + configs[ i ].AutoScalingGroupName + "\" >Delete</a>" ) );

					$( "#AutoScaleGroupTable tbody" ).append( row );
				}

				$( ".delete-btn" ).click( function( ) {
		          	deleteAutoScalingGroup( $( this ).data( "autoscalename" ) );
		          	return false;
		        } );
			} else {
				var row = $( "<tr></tr>" );

				row.append( $( "<td></td>" ).html( "None" ) );
				row.append( $( "<td></td>" ).html( "None" ) );
				row.append( $( "<td></td>" ).html( "None" ) );
				row.append( $( "<td></td>" ).html( "None" ) );
				row.append( $( "<td></td>" ).html( "None" ) );

				$( "#AutoScaleGroupTable tbody" ).append( row );
			}
		}
	} );
}

function getScalingPolicies( ) {
	$.ajax( {
		method : "GET",
		url : "aws/Policy.php",
		dataType : "json",
		success : function( json ) {
			$( "#PolicyTable tbody" ).html( "" );

			var configs = json.ScalingPolicies;
			if( configs != undefined && configs.length > 0 ) {
				for( var i = 0; i < configs.length; ++i ) {
					var row = $( "<tr></tr>" );
					row.append( $( "<td></td>" ).html( configs[ i ].PolicyName ) );
					row.append( $( "<td></td>" ).html( configs[ i ].AutoScalingGroupName ) );
					row.append( $( "<td></td>" ).html( configs[ i ].ScalingAdjustment ) );
					row.append( $( "<td></td>" ).html( configs[ i ].AdjustmentType ) );
					row.append( $( "<td></td>" ).html( configs[ i ].Cooldown ) );
					row.append( $( "<td></td>" ).html( "<a href=\"#\" role=\"button\" class=\"btn btn-danger delete-btn\" data-policyname=\"" 
						+ configs[ i ].PolicyName + "\" data-autoscalename=\"" + configs[ i ].AutoScalingGroupName + "\" >Delete</a>" ) );

					$( "#PolicyTable tbody" ).append( row );
				}

				$( ".delete-btn" ).click( function( ) {
		          	deleteScalingPolicy( $( this ).data( "policyname" ), $( this ).data( "autoscalename" ) );
		          	return false;
		        } );
			} else {
				var row = $( "<tr></tr>" );

				row.append( $( "<td></td>" ).html( "None" ) );
				row.append( $( "<td></td>" ).html( "None" ) );
				row.append( $( "<td></td>" ).html( "None" ) );
				row.append( $( "<td></td>" ).html( "None" ) );
				row.append( $( "<td></td>" ).html( "None" ) );
				row.append( $( "<td></td>" ).html( "None" ) );

				$( "#PolicyTable tbody" ).append( row );
			}
		}
	} );
}

function getAlarmMetrics( ) {
	$.ajax( {
		method : "GET",
		url : "aws/MetricAlarm.php",
		dataType : "json",
		success : function( json ) {
			$( "#AlarmMetricTable tbody" ).html( "" );

			var configs = json.MetricAlarms;
			if( configs != undefined && configs.length > 0 ) {
				for( var i = 0; i < configs.length; ++i ) {
					var row = $( "<tr></tr>" );
					row.append( $( "<td></td>" ).html( configs[ i ].AlarmName ) );
					row.append( $( "<td></td>" ).html( configs[ i ].AlarmDescription ) );
					row.append( $( "<td></td>" ).html( configs[ i ].MetricName ) );
					row.append( $( "<td></td>" ).html( configs[ i ].StateValue ) );
					row.append( $( "<td></td>" ).html( "<a href=\"#\" role=\"button\" class=\"btn btn-danger delete-btn\" data-alarmname=\"" 
						+ configs[ i ].AlarmName + "\" >Delete</a>" ) );

					$( "#AlarmMetricTable tbody" ).append( row );
				}

				$( ".delete-btn" ).click( function( ) {
		          	deleteMetricAlarm( $( this ).data( "alarmname" ) );
		          	return false;
		        } );
			} else {
				var row = $( "<tr></tr>" );

				row.append( $( "<td></td>" ).html( "None" ) );
				row.append( $( "<td></td>" ).html( "None" ) );
				row.append( $( "<td></td>" ).html( "None" ) );
				row.append( $( "<td></td>" ).html( "None" ) );
				row.append( $( "<td></td>" ).html( "None" ) );

				$( "#AlarmMetricTable tbody" ).append( row );
			}
		}
	} );
}

function inputsToJson( formID ) {
	var jArr = {};

	$( "#" + formID + " input" ).each( function ( i, elem ) {
		jArr[ $( elem ).attr( "id" ) ] = $( elem ).val( );
	} );

	return jArr;
}

function putLaunchConfiguration( ) {
	var data = inputsToJson( "LaunchConfigurationForm" );

	if( data[ "LaunchConfigurationName" ] == "" ) {
		// alert it
		return false;
	}

	if( data[ "ImageId" ] == "" ) {
		// alert it
		return false;
	}

	if( data[ "InstanceType" ] == "" ) {
		// alert it
		return false;
	}

	$.ajax( {
		method : "PUT",
		url : "aws/LaunchConfig.php",
		data : JSON.stringify( data ),
		processData : false,
		contentType : "application/json",
		success : function( ) {
			window.location.reload( true );
		}
	} );
}

function putAutoScalingGroup( ) {
	var data = inputsToJson( "AutoScalingGroupForm" );

	if( data[ "AutoScalingGroupName" ] == "" ) {
		// alert it
		return false;
	}

	if( data[ "LaunchConfigurationName" ] == "" ) {
		// alert it
		return false;
	}

	if( data[ "MinSize" ] == "" ) {
		// alert it
		return false;
	}

	if( data[ "MaxSize" ] == "" ) {
		// alert it
		return false;
	}

	$.ajax( {
		method : "PUT",
		url : "aws/AutoScalingGroup.php",
		data : JSON.stringify( data ),
		processData : false,
		contentType : "application/json",
		success : function( ) {
			window.location.reload( true );
		}
	} );
}

function putScalingPolicy( ) {
	var data = inputsToJson( "PolicyForm" );

	if( data[ "AutoScalingGroupName" ] == "" ) {
		// alert it
		return false;
	}

	if( data[ "PolicyName" ] == "" ) {
		// alert it
		return false;
	}

	if( data[ "ScalingAdjustment" ] == "" ) {
		// alert it
		return false;
	}

	if( data[ "AdjustmentType" ] == "" ) {
		// alert it
		return false;
	}

	$.ajax( {
		method : "PUT",
		url : "aws/Policy.php",
		data : JSON.stringify( data ),
		processData : false,
		contentType : "application/json",
		success : function( ) {
			window.location.reload( true );
		}
	} );
}

function putAlarmMetric( ) {
	var data = inputsToJson( "AlarmMetricForm" );

	if( data[ "AutoScalingGroupName" ] == "" ) {
		// alert it
		return false;
	}

	if( data[ "PolicyARN" ] == "" ) {
		// alert it
		return false;
	}

	if( data[ "AlarmName" ] == "" ) {
		// alert it
		return false;
	}

	if( data[ "MetricName" ] == "" ) {
		// alert it
		return false;
	}

	if( data[ "Namespace" ] == "" ) {
		// alert it
		return false;
	}

	if( data[ "Statistic" ] == "" ) {
		// alert it
		return false;
	}

	if( data[ "Period" ] == "" ) {
		// alert it
		return false;
	}

	if( data[ "EvaluationPeriods" ] == "" ) {
		// alert it
		return false;
	}

	if( data[ "Threshold" ] == "" ) {
		// alert it
		return false;
	}

	if( data[ "AlarmName" ] == "" ) {
		// alert it
		return false;
	}

	if( data[ "ComparisonOperator" ] == "" ) {
		// alert it
		return false;
	}

	if( data[ "Unit" ] == "" ) {
		// alert it
		return false;
	}

	console.log( data );

	$.ajax( {
		method : "PUT",
		url : "aws/MetricAlarm.php",
		data : JSON.stringify( data ),
		processData : false,
		contentType : "application/json",
		success : function( ) {
			window.location.reload( true );
		}
	} );
}

function deleteLaunchConfiguration( configName ) {
	$.ajax( {
		method : "DELETE",
		url : "aws/LaunchConfig.php?LaunchConfigurationName=" + configName,
		success : function( ) {
			window.location.reload( true );
		}
	} );
}

function deleteAutoScalingGroup( groupName ) {
	$.ajax( {
		method : "DELETE",
		url : "aws/AutoScalingGroup.php?AutoScalingGroupName=" + groupName,
		success : function( ) {
			window.location.reload( true );
		}
	} );
}

function deleteScalingPolicy( policyName, groupName ) {
	$.ajax( {
		method : "DELETE",
		url : "aws/Policy.php?PolicyName=" + policyName + "&AutoScalingGroupName=" + groupName,
		success : function( ) {
			window.location.reload( true );
		}
	} );
}

function deleteMetricAlarm( alarmName ) {
	$.ajax( {
		method : "DELETE",
		url : "aws/MetricAlarm.php?AlarmName=" + alarmName,
		success : function( ) {
			window.location.reload( true );
		}
	} );
}

function setARNSource( ) {
	$.ajax( {
		method : "GET",
		url : "aws/Policy.php",
		dataType : "json",
		success : function( json ) {
			var configs = json.ScalingPolicies;
			if( configs != undefined && configs.length > 0 ) {
				ARNSource = new Array( );
				ARNMap = {};
				for( var i = 0; i < configs.length; ++i ) {
					var key = configs[ i ].AutoScalingGroupName + "/" + configs[ i ].PolicyName;
					ARNSource.push( key );
					ARNMap[ key ] = configs[ i ].PolicyARN;
				}

				$( "#PolicyARN" ).typeahead( {
					source : ARNSource,
					updater : function( item ) {
						return ARNMap[ item ];
					}
				} );
			}
		}
	} );
}

function setComparisonOperators( ) {
	ComparisonOperators = [
		"GreaterThanOrEqualToThreshold",
		"GreaterThanThreshold",
		"LessThanOrEqualToThreshold",
		"LessThanThreshold"
	];

	$( "#ComparisonOperator" ).typeahead( {
		source : ComparisonOperators
	} );
}

function setStatisticValues( ) {
	StatisticValues = [
		"Average",
		"Maximum",
		"Minumum",
		"SampleCount",
		"Sum"
	];

	$( "#Statistic" ).typeahead( {
		source: StatisticValues
	} );
}

function setUnitValues( ) {
	UnitValues = [
		"Seconds",
		"Microseconds",
		"Milliseconds",
		"Bytes",
		"Kilobytes",
		"Megabytes",
		"Gigabytes",
		"Terabytes",
		"Bits",
		"Kilobits",
		"Megabits",
		"Gigabits",
		"Terabits",
		"Percent",
		"Count",
		"Bytes/Second",
		"Kilobytes/Second",
		"Megabytes/Second",
		"Gigabytes/Second",
		"Terabytes/Second",
		"Bits/Second",
		"Kilobits/Second",
		"Megabits/Second",
		"Gigabits/Second",
		"Terabits/Second",
		"Count/Second",
		"None"
	];

	$( "#Unit" ).typeahead( {
		source : UnitValues
	} );
}

function setAutoScalingGroups( ) {
	$.ajax( {
		method : "GET",
		url : "aws/AutoScalingGroup.php",
		dataType : "json",
		success : function( json ) {
			var configs = json.AutoScalingGroups;
			if( configs != undefined && configs.length > 0 ) {
				AutoScalingGroups = new Array( );
				for( var i = 0; i < configs.length; ++i ) {
					var key = configs[ i ].AutoScalingGroupName;
					ARNSource.push( key );
				}

				$( "#AutoScalingGroupName" ).typeahead( {
					source : AutoScalingGroups
				} );
			}
		}
	} );
}

function setMetrics( ) {
	Metrics = [
		"CPUUtilization",
		"DiskReadOps",
		"DiskWriteOps",
		"DiskReadBytes",
		"DiskWriteBytes",
		"NetworkOut",
		"NetworkIn",
		"StatusCheckFailed",
		"StatusCheckFailed_Instance",
		"StatusCheckFailed_System"
	];

	$( "#MetricName" ).typeahead( {
		source : Metrics
	} );
}
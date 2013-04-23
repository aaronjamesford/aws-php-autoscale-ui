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

	console.log( data );
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
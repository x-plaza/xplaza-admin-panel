<?php

namespace App\Libraries;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HandleApi {

	public function __construct() {

	}


	/**
	 * @param $curloptURL
	 * @param $method
	 * @param $fieldData
	 *
	 * @return bool|string
	 */

//	public static function getCURLResult( $curloptURL, $method, $license_no ) {
//
//		$onlyToken = self::getValidToken();
//
//		if ( isset( $onlyToken ) ) {
//			$curl = curl_init();
//			curl_setopt_array( $curl, array(
//				CURLOPT_URL            => "$curloptURL",
//				CURLOPT_RETURNTRANSFER => true,
//				CURLOPT_ENCODING       => "",
//				CURLOPT_MAXREDIRS      => 10,
//				CURLOPT_TIMEOUT        => 0,
//				CURLOPT_SSL_VERIFYHOST => 0,
//				CURLOPT_SSL_VERIFYPEER => 0,
//				CURLOPT_FOLLOWLOCATION => true,
//				CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
//				CURLOPT_CUSTOMREQUEST  => "$method",
//				CURLOPT_POSTFIELDS     => http_build_query( array(
//					'license_no' => $license_no,
//				) ),
//				CURLOPT_HTTPHEADER     => array(
//					"Authorization: Bearer $onlyToken",
//					"Content-Type: application/x-www-form-urlencoded",
//				),
//			) );
//			$response = curl_exec( $curl );
//			curl_close( $curl );
//
//			return $response;
//		} else {
//			return false;
//		}
//	}

	/**
	 * @return mixed
	 */

	public static function getValidToken() {

        $tokenData = json_decode( self::getToken() );
        return $tokenData->data;
	}

	/**
	 * @return false|string
	 */

	public static function getToken() {

		$prp_api_url_for_token = env( 'PRP_API_BASE_URL','http://localhost:8044' ) . '/d-api/get-token';
		$prp_client_id         = env( 'PRP_API_CLIENT_ID','390a0c1ay3fd049' );
		$prp_client_secret     = env( 'PRP_API_CLIENT_SECRET','ca5a2d0cf7c304b7c5' );
		$prp_grant_type        = env( 'PRP_API_GRANT_TYPE','client_credentials' );

		try {
			$curl = curl_init();
			curl_setopt( $curl, CURLOPT_POST, 1 );
			curl_setopt( $curl, CURLOPT_POSTFIELDS, http_build_query( array(
				'client_id'     => $prp_client_id,
				'client_secret' => $prp_client_secret,
				'grant_type'    => $prp_grant_type
			) ) );
			curl_setopt( $curl, CURLOPT_URL, "$prp_api_url_for_token" );
			curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt( $curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
			curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, 0 );
			curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, 0 );
			$result = curl_exec( $curl );


			if ( ! $result || ! property_exists( json_decode( $result ), 'access_token' ) ) {
				$data = [ 'responseCode' => 0, 'msg' => 'SMS API connection failed!', 'data' => '' ];

				return json_encode( $data );
			}
			curl_close( $curl );
			$decoded_json = json_decode( $result, true );
			$data         = [
				'responseCode' => 1,
				'msg'          => 'Success',
				'data'         => $decoded_json['access_token'],
				'expires_in'   => $decoded_json['expires_in']
			];

			return json_encode( $data );

		} catch ( Exception $e ) {
			return false;
		}
	}

	/**
	 * @param $type
	 * @param $license_no
	 *
	 * @return bool|mixed
	 */
//	public static function getApiData( $type, $license_no ) {
//		if ( empty( $type ) || empty( $license_no ) ) {
//			return false;
//		}
//
//		$prp_api_url = '';
//
//		if ( $type == 'OFFICE_INFO' ) {
//			$prp_api_url = env( 'PRP_API_BASE_URL' ) . '/d-api/office-address-info/get-office-info';
//		} else if ( $type == 'JAMANOT_INFO' ) {
//			$prp_api_url = env( 'PRP_API_BASE_URL' ) . '/d-api/jamanot-information/get-jamanot-information';
//		} else if ( $type == 'EMPLOYEE_INFO' ) {
//			$prp_api_url = env( 'PRP_API_BASE_URL' ) . '/d-api/employee-information/get-employee-information';
//		}
//
//
//		try {
//			$method           = 'POST';
//			$curloptURL       = $prp_api_url;
//			$response         = self::getCURLResult( $curloptURL, $method, $license_no );
//			$decoded_response = json_decode( $response, true );
//
//			if ( $response && $decoded_response['responseBody']['status'] === 200 ) {
//				return $decoded_response;
//			} else {
//				return false;
//			}
//
//		} catch ( \Exception $e ) {
//			return false;
//		}
//	}




	/**
	 * @param $curloptURL
	 * @param $method
	 * @param $fieldData
	 *
	 * @return bool|string
	 */

	public static function getCURLOutput( $curloptURL, $method, $fieldData ) {

		$onlyToken = 'Dummy';//self::getValidToken();

		if ( isset( $onlyToken ) ) {

			$curl = curl_init();
			curl_setopt_array( $curl, array(
				CURLOPT_URL            => "$curloptURL",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING       => "",
				CURLOPT_MAXREDIRS      => 10,
				CURLOPT_TIMEOUT        => 0,
				CURLOPT_SSL_VERIFYHOST => 0,
				CURLOPT_SSL_VERIFYPEER => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST  => "$method",
				CURLOPT_POSTFIELDS     => $fieldData,
				CURLOPT_HTTPHEADER     => array(
					"Authorization: Bearer $onlyToken",
					"Content-Type: application/json",
				),
			) );
			$response = curl_exec( $curl );
			curl_close( $curl );

			return $response;
		} else {
			return false;
		}
	}

	/**
	 * @param $appData
	 *
	 * @return bool
	 */


//    public static function updateAgencyApi( $bodyDataArray ) {
//        try {
//
//            if ( !is_array( $bodyDataArray ) || count( $bodyDataArray ) == 0 ) {
//                return false;
//            }
//
//            $finalData = $bodyDataArray;
//            $prp_api_url = env( 'PRP_API_BASE_URL' ) . '/d-api/lms-amendment-api/update-agency-information';
//            $fieldData   = json_encode( $finalData );
//            $curlOutput  = self::getCURLOutput( $prp_api_url, 'POST', $fieldData );
//
//            if ( ! $curlOutput ) {
//                return false;
//            }
//
//            if(isset(json_decode($curlOutput)->responseBody->status) && json_decode($curlOutput)->responseBody->status == 200){
//                return true;
//            }else{
//                return false;
//            }
//
//        } catch ( Exception $e ) {
//            return false;
//        }
//    }
	/*     * ****************************End of Class***************************** */
}

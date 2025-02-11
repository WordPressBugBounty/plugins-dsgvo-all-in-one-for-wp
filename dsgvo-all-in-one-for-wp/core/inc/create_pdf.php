<?php
if ( ! defined( 'ABSPATH' ) ) exit;

session_start();

error_reporting(0);

if ( is_user_logged_in() ) {
	
$language = $language;
		
$users = get_users();

foreach($users as $user){    
	
	if (get_current_user_id() == $user->ID) {
		
			require(plugin_dir_path( __FILE__ ).'pdf/fpdf.php');
			
			$user_meta = get_user_meta ( $user->ID);
			$useripdata = explode(":", $user_meta['community-events-location'][0]);
			$userip = str_replace('"',"", $useripdata);
			$userip = str_replace(';}',"", $userip);	
			if (null !== session_id()) {
				$sessid = session_id();
			} else {
				$sessid = 1;
			}
			update_option('dsgvoaiousrlang'.$sessid, $language, false);
			class PDF extends FPDF {	
			
				function Header() {
					if (null !== session_id()) {
						$sessid = session_id();
					} else {
						$sessid = 1;
					}					
					$language = get_option('dsgvoaiousrlang'.$sessid, 'de');
					
					$this->SetFont('Arial','B',15);
					// Move to the right
					$this->Cell(60);
					// Title
					if ($language == "de") {
						$this->Cell(70,10, "Benutzerdatenauskunft",0,0,'C');
					} else if ($language == "en") {
						$this->Cell(70,10, "User data information",0,0,'C');
					} else if ($language == "it") {
						$this->Cell(70,10, "Informazioni sui dati dell'utente",0,0,'C');
					} else {
						$this->Cell(70,10, "Benutzerdatenauskunft",0,0,'C');
					}
					// Line break
					$this->Ln(20);
				}
				// Page footer
				function Footer() {
					if (null !== session_id()) {
						$sessid = session_id();
					} else {
						$sessid = 1;
					}					
					$language = get_option('dsgvoaiousrlang'.$sessid, 'de');
					$site_title = get_option('blogname');
					// Position at 1.5 cm from bottom
					$this->SetY(-20);
					// Arial italic 8
					$this->SetFont('Arial','',10);
					// Page number
					if ($language == "de") {
						$this->Cell(0,10,'Seite'.$this->PageNo().'/1',0,0,'C');
					} else if ($language == "en") {
						$this->Cell(0,10, 'Page'.$this->PageNo().'/1',0,0,'C');
					} else if ($language == "it") {
						$this->Cell(0,10, 'Pagina'.$this->PageNo().'/1',0,0,'C');
					} else {
						$this->Cell(0,10, 'Seite'.$this->PageNo().'/1',0,0,'C');
					}					
					$this->Ln(5);
					if ($language == "de") {
					$this->Cell(0,10, "Generiert durch".' '.$site_title.' - '.get_site_url(),0,0,'C');
					} else if ($language == "en") {
					$this->Cell(0,10,"Generated by".' '.$site_title.' - '.get_site_url(),0,0,'C');
					} else if ($language == "it") {
					$this->Cell(0,10, "Generato da".' '.$site_title.' - '.get_site_url(),0,0,'C');
					} else {
					$this->Cell(0,10, "Generiert durch".' '.$site_title.' - '.get_site_url(),0,0,'C');
					}					
					$this->Ln(5);
					if ($language == "de") {
					$this->Cell(0,10, "Generiert am".' '.gmdate('d.m.Y').' um '.gmdate('H:i:s'),0,0,'C');
					} else if ($language == "en") {
					$this->Cell(0,10, "Generated on".' '.gmdate('d.m.Y').' um '.gmdate('H:i:s'),0,0,'C');
					} else if ($language == "it") {
					$this->Cell(0,10, "Generato su".' '.gmdate('d.m.Y').' um '.gmdate('H:i:s'),0,0,'C');
					} else {
					$this->Cell(0,10, "Generiert am".' '.gmdate('d.m.Y').' um '.gmdate('H:i:s'),0,0,'C');
					}						
					$this->Ln(5);
		
				}
			

			}
			$pdf = new PDF();
			$pdf->AddPage();
			$pdf->SetFont('Arial','B',12);
			if ($language == "de") {
				$pdf->Cell(40,10,"Benutzerdaten");
			} else if ($language == "en") {
				$pdf->Cell(40,10,"User data");
			} else if ($language == "it") {
				$pdf->Cell(40,10,"Dati utente");
			} else {
				$pdf->Cell(40,10,"Benutzerdaten");
			}				
			$pdf->Ln(8);			
			$pdf->SetFont('Arial','',12);
			if ($language == "de") {
				$pdf->Cell(40,10,"Benutzername".": ".$user->user_login);
			} else if ($language == "en") {
				$pdf->Cell(40,10,"Username".": ".$user->user_login);
			} else if ($language == "it") {
				$pdf->Cell(40,10,"Nome utente".": ".$user->user_login);
			} else {
				$pdf->Cell(40,10,"Benutzername".": ".$user->user_login);
			}			
			if (get_user_meta ( $user->ID)['first_name'][0]) {
				$pdf->Ln(8);
				if ($language == "de") {
					$pdf->Cell(40,10,"Vorname".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['first_name'][0])));
				} else if ($language == "en") {
					$pdf->Cell(40,10,"Firstname".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['first_name'][0])));
				} else if ($language == "it") {
					$pdf->Cell(40,10,"Nome".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['first_name'][0])));
				} else {
					$pdf->Cell(40,10,"Vorname".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['first_name'][0])));
				}				
			}	
			
			if (get_user_meta ( $user->ID)['last_name'][0]) {
				$pdf->Ln(8);
				if ($language == "de") {
					$pdf->Cell(40,10,"Nachname".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['first_name'][0])));
				} else if ($language == "en") {
					$pdf->Cell(40,10,"Lastname".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['first_name'][0])));
				} else if ($language == "it") {
					$pdf->Cell(40,10,"Cognome".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['first_name'][0])));
				} else {
					$pdf->Cell(40,10,"Nachname".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['first_name'][0])));
				}				
			}
			
			$user_id = get_current_user_id(); 
			$user_info = get_userdata($user_id);
			$mailadresje = $user_info->user_email;		
					
			if ($mailadresje) {
				$pdf->Ln(8);
				if ($language == "de") {
					$pdf->Cell(40,10,"Email Adresse".": ".$mailadresje);
				} else if ($language == "en") {
					$pdf->Cell(40,10,"Email".": ".$mailadresje);
				} else if ($language == "it") {
					$pdf->Cell(40,10,"Indirizzo e-mail".": ".$mailadresje);
				} else {
					$pdf->Cell(40,10,"Email Adresse".": ".$mailadresje);
				}					
			}				
			
			if (get_user_meta ( $user->ID)['billing_email'][0]) {			
				$pdf->Ln(8);
				if ($language == "de") {
					$pdf->Cell(40,10,"Shop Email Adress".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['billing_email'][0])));
				} else if ($language == "en") {
					$pdf->Cell(40,10,"Shop Email Adresse".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['billing_email'][0])));
				} else if ($language == "it") {
					$pdf->Cell(40,10,"Indirizzo e-mail del negozio".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['billing_email'][0])));
				} else {
					$pdf->Cell(40,10,"Shop Email Adresse".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['billing_email'][0])));
				}				
			}

			if (get_user_meta ( $user->ID)['billing_phone'][0]) {			
				$pdf->Ln(8);
				if ($language == "de") {
					$pdf->Cell(40,10,"Telefonnummer".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['billing_phone'][0])));
				} else if ($language == "en") {
					$pdf->Cell(40,10,"Phone number".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['billing_phone'][0])));
				} else if ($language == "it") {
					$pdf->Cell(40,10,"Numero di telefono".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['billing_phone'][0])));
				} else {
					$pdf->Cell(40,10,"Telefonnummer".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['billing_phone'][0])));
				}			
			}
			$pdf->Ln(20);	
			$datacount = 0;
			if ( class_exists( 'WooCommerce' ) ) {
			
			$pdf->Ln(20);
			$pdf->SetFont('Arial','B',12);
				if ($language == "de") {
					$pdf->Cell(40,10,"Rechnungsadresse");
				} else if ($language == "en") {
					$pdf->Cell(40,10,"Billing address");
				} else if ($language == "it") {
					$pdf->Cell(40,10,"Indirizzo di fatturazione");
				} else {
					$pdf->Cell(40,10,"Rechnungsadresse");
				}			
			$pdf->Ln(8);			
			$pdf->SetFont('Arial','',12);
			
			}

			if (get_user_meta ( $user->ID)['billing_company'][0]) {
				if ($language == "de") {
				$pdf->Cell(40,10,"Firma".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['billing_company'][0])));
				} else if ($language == "en") {
				$pdf->Cell(40,10,"Company".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['billing_company'][0])));
				} else if ($language == "it") {
				$pdf->Cell(40,10,"Azienda".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['billing_company'][0])));
				} else {
				$pdf->Cell(40,10,"Firma".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['billing_company'][0])));
				}				
				$pdf->Ln(8);
				$datacount = $datacount+1;
			}

			
			if (get_user_meta ( $user->ID)['billing_first_name'][0]) {
				if ($language == "de") {
				$pdf->Cell(40,10,"Vorname".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['billing_first_name'][0])));
				} else if ($language == "en") {
				$pdf->Cell(40,10,"Firstname".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['billing_first_name'][0])));
				} else if ($language == "it") {
				$pdf->Cell(40,10,"Nome".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['billing_first_name'][0])));
				} else {
				$pdf->Cell(40,10,"Vorname".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['billing_first_name'][0])));
				}				
				$pdf->Ln(8);
				$datacount = $datacount+1;
			}
			
			if (get_user_meta ( $user->ID)['billing_last_name'][0]) {	
				if ($language == "de") {
				$pdf->Cell(40,10,"Nachname".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['billing_last_name'][0])));
				} else if ($language == "en") {
				$pdf->Cell(40,10,"Lastname".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['billing_last_name'][0])));
				} else if ($language == "it") {
				$pdf->Cell(40,10,"Cognome".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['billing_last_name'][0])));
				} else {
				$pdf->Cell(40,10,"Nachname".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['billing_last_name'][0])));
				}				
				$pdf->Ln(8);
				$datacount = $datacount+1;
			}
			
			if (get_user_meta ( $user->ID)['billing_address_1'][0]) {
				if ($language == "de") {
				$pdf->Cell(40,10,"Adresse".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['billing_address_1'][0])));
				} else if ($language == "en") {
				$pdf->Cell(40,10,"Adress".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['billing_address_1'][0])));
				} else if ($language == "it") {
				$pdf->Cell(40,10,"Indirizzo".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['billing_address_1'][0])));
				} else {
				$pdf->Cell(40,10,"Adresse".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['billing_address_1'][0])));
				}					
				$pdf->Ln(8);
				$datacount = $datacount+1;
			}
			
			if (get_user_meta ( $user->ID)['billing_city'][0]) {
				if ($language == "de") {
				$pdf->Cell(40,10,"Ort".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['billing_city'][0])));
				} else if ($language == "en") {
				$pdf->Cell(40,10,"Place".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['billing_city'][0])));
				} else if ($language == "it") {
				$pdf->Cell(40,10,"Posto".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['billing_city'][0])));
				} else {
				$pdf->Cell(40,10,"Ort".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['billing_city'][0])));
				}					
				$pdf->Ln(8);
				$datacount = $datacount+1;
			}
			
			if (get_user_meta ( $user->ID)['billing_postcode'][0]) {
				if ($language == "de") {
				$pdf->Cell(40,10,"PLZ".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['billing_postcode'][0])));
				} else if ($language == "en") {
				$pdf->Cell(40,10,"Zip Code".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['billing_postcode'][0])));
				} else if ($language == "it") {
				$pdf->Cell(40,10,"Codice postale".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['billing_postcode'][0])));
				} else {
				$pdf->Cell(40,10,"PLZ".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['billing_postcode'][0])));
				}					
				$pdf->Ln(8);
				$datacount = $datacount+1;
			}
			
			if (get_user_meta ( $user->ID)['billing_country'][0]) {
				if ($language == "de") {
				$pdf->Cell(40,10,"Land".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['billing_country'][0])));
				} else if ($language == "en") {
				$pdf->Cell(40,10,"Country".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['billing_country'][0])));
				} else if ($language == "it") {
				$pdf->Cell(40,10,"Terra".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['billing_country'][0])));
				} else {
				$pdf->Cell(40,10,"Land".": ".utf8_decode(html_entity_decode(get_user_meta ( $user->ID)['billing_country'][0])));
				}					
				$pdf->Ln(20);
				$datacount = $datacount+1;
			}
			
			if ($datacount < 1 && class_exists( 'WooCommerce' )) {
				if ($language == "de") {
				$pdf->Cell(40,10,"Es wurden keine Daten gefunden.");
				} else if ($language == "en") {
				$pdf->Cell(40,10,"No data were found.");
				} else if ($language == "it") {
				$pdf->Cell(40,10,"Non sono stati trovati dati.");
				} else {
				$pdf->Cell(40,10,"Es wurden keine Daten gefunden.");
				}					
				$pdf->Ln(20);
			}
			
			if (isset($userip[6])) {
							
				$pdf->SetFont('Arial','B',12);
				if ($language == "de") {
				$pdf->Cell(40,10,"IP Adresse");
				} else if ($language == "en") {
				$pdf->Cell(40,10,"IP Adress");
				} else if ($language == "it") {
				$pdf->Cell(40,10,"Indirizzo IP");
				} else {
				$pdf->Cell(40,10,"IP Adresse");
				}						
				$pdf->SetFont('Arial','',12);
				$pdf->Ln(8);			
				if ($language == "de") {
				$pdf->Cell(40,10,"IP Adresse".": ".$userip[6]);
				} else if ($language == "en") {
				$pdf->Cell(40,10,"IP Adress".": ".$userip[6]);
				} else if ($language == "it") {
				$pdf->Cell(40,10,"Indirizzo IP".": ".$userip[6]);
				} else {
				$pdf->Cell(40,10,"IP Adresse".": ".$userip[6]);
				}					
			}
			
			if ($language == "de") {
				if (get_option("dsgvo_pdf_text")) {
					$pdf->Ln(20);
					$pdf->MultiCell( 185, 7, utf8_decode(html_entity_decode(get_option("dsgvo_pdf_text"))), 10);
				}				
			}
			
			if ($language == "en") {
				if (get_option("dsgvo_pdf_text_en")) {
					$pdf->Ln(20);
					$pdf->MultiCell( 185, 7, utf8_decode(html_entity_decode(get_option("dsgvo_pdf_text_en"))), 10);
				}				
			}
			
			if ($language == "it") {
				if (get_option("dsgvo_pdf_text_it")) {
					$pdf->Ln(20);
					$pdf->MultiCell( 185, 7, utf8_decode(html_entity_decode(get_option("dsgvo_pdf_text_it"))), 10);
				}				
			}			
			
			$site_title = get_option('blogname').uniqid();
			
			$current_user = wp_get_current_user();
			$upload_dir   = wp_upload_dir();
			 
			if ( isset( $current_user->id ) && ! empty( $upload_dir['basedir'] ) ) {
				$cachedir = $upload_dir['basedir'].'/dsgvoaiocache';
					if ( ! file_exists( $cachedir ) ) {
					wp_mkdir_p( $cachedir );
				}
			}	

			$output_file_dir = $upload_dir['basedir'].'/dsgvoaiocache/userdatas_'.$site_title.'.pdf';
			
			$output_file_url = $upload_dir['baseurl'].'/dsgvoaiocache/userdatas_'.$site_title.'.pdf';

			$pdf->Output('F', $output_file_dir);

			

	}
}
} else {
	echo 'You are currently not logged in and you call the file directly...'. '<br />';

}
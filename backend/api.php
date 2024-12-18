<?php
 header('Content-Type: application/json; charset=utf-8');
  header('Access-Control-Allow-Origin: *');
//include('connexion.php');
  //margin-right: 50%;
     // top: 4px;
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
	$dbname = "pfe";
  //  $dbname = "assurances biat";
	
    $conn = new mysqli($servername, $username, $password, $dbname);
	
// Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }if ($_REQUEST['cmd']=='liste_compte')
       {
        $data = [];
        $sql1="SELECT X.*,(SELECT S.titre FROM `service` S INNER JOIN compte CO on Co.id_service = S.id where Co.id_service = S.id AND X.id=Co.id) as 'personnel' FROM compte X";
        if ($result = $conn->query($sql1)) {

          while ($row = $result->fetch_assoc()) {

            array_push($data, $row);
          }}
          $result = json_encode($data,JSON_UNESCAPED_UNICODE ); 

          echo ($result);
        }
		 if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
	//Afficher offre
	if ( $_REQUEST['cmd']=='afficher_offre')
 {$id=$_REQUEST['id'];
  $data = [];
 
  $sql1="SELECT offre FROM demandes where id=$id";
  if ($result = $conn->query($sql1)) {

    while ($row = $result->fetch_assoc()) {

      array_push($data, $row);
    }}
    $result = json_encode($data,JSON_UNESCAPED_UNICODE ); 

    echo ($result);
  }
//inserion OFFRE
        if ( $_REQUEST['cmd']=='ajouter_offre')
          {$offre = $_REQUEST['offre'];
	  $id = $_REQUEST['id'];
        $sql2="UPDATE `demandes` SET `offre`='$offre' WHERE id=$id";
            // $res1 = $conn->query($sql1) or die($conn->error);
                     //if ($result = $conn->query($sql1)) 
        if ($result2 = $conn->query($sql2)) {
         $result2 = json_encode('success',JSON_UNESCAPED_UNICODE ); 
         /* fetch associative array */

       }else
       {$result2 = json_encode('echec',JSON_UNESCAPED_UNICODE );} 
       echo ($result2);
     }
	//Ajouter personne physique
	
  if ( $_REQUEST['cmd']=='ajout_personne_physique1')
  {$data=[];
	  $titre=$_REQUEST['titre'];
	  $nom=$_REQUEST['nom'];
	  $prenom=$_REQUEST['prenom'];
	  $nom_jeune_fille=$_REQUEST['nom_jeune_fille'];
	  $situation_familiale=$_REQUEST['situation_familiale'];
	  $date_naissance=$_REQUEST['date_naissance'];
	  $type_client=$_REQUEST['type_client'];
	  $physique_morale=$_REQUEST['physique_morale'];
	  $secteur=$_REQUEST['secteur'];
	  $seceur_dactivite=$_REQUEST['seceur_dactivite'];
	  $sexe=$_REQUEST['sexe'];
	  $nationalite=$_REQUEST['nationalite'];
	  $cin=$_REQUEST['cin'];
	  $passeport=$_REQUEST['passeport'];
	  $id=$_REQUEST['id'];
    $sql2="INSERT INTO `personnes_physique`( `titre`, `nom`, `prenom`, `nom_jeune_fille`, `situation_familiale`, 
	`date_naissance`, `type_client`, `physique_morale`, `secteur`, `seceur_dactivite`, `sexe`, `nationalite`, `cin`, `passeport`,
	`id_client`) VALUES ('$titre','$nom','$prenom','$nom_jeune_fille','$situation_familiale','$date_naissance','$type_client',
	'$physique_morale','$secteur','$seceur_dactivite','$sexe','$nationalite',$cin,$passeport,
	(select id from client where id_compte=(select id from compte where id=$id)))";
    if ($result2 = $conn->query($sql2)) {
     $result2 = json_encode('success',JSON_UNESCAPED_UNICODE ); 
     // fetch associative array 

   }else
   {$result2 = json_encode('echec',JSON_UNESCAPED_UNICODE );} 
   echo ($result2);}
 	
 //Modification personne physique
	
  if ( $_REQUEST['cmd']=='modifier_personne_physique1')
  {
	  $titre=$_REQUEST['titre'];
	  $nom=$_REQUEST['nom'];
	  $prenom=$_REQUEST['prenom'];
	  $nom_jeune_fille=$_REQUEST['nom_jeune_fille'];
	  $situation_familiale=$_REQUEST['situation_familiale'];
	  $date_naissance=$_REQUEST['date_naissance'];
	  $type_client=$_REQUEST['type_client'];
	  $physique_morale=$_REQUEST['physique_morale'];
	  $secteur=$_REQUEST['secteur'];
	  $seceur_dactivite=$_REQUEST['seceur_dactivite'];
	  $sexe=$_REQUEST['sexe'];
	  $nationalite=$_REQUEST['nationalite'];
	  $cin=$_REQUEST['cin'];
	  $passeport=$_REQUEST['passeport'];
	  $id=$_REQUEST['id'];
    $sql2="UPDATE `personnes_physique` SET 
	`titre`='titre',
	`nom`='$nom', 
	`prenom`='$prenom',
	`nom_jeune_fille`='$nom_jeune_fille',
	`situation_familiale`='$situation_familiale', 
	`date_naissance`='$date_naissance',
	`type_client`='$type_client', 
	`physique_morale`='$physique_morale', 
	`secteur`='$secteur', 
	`seceur_dactivite`='$seceur_dactivite', 
	`sexe`='$sexe', 
	`nationalite`='$nationalite',
	`cin`='$cin',
	`passeport`='$passeport'
	WHERE 	`id_client`=(select id from client where id_compte=(select id from compte where id=$id)) ";
           
    if ($result2 = $conn->query($sql2)) {
     $result2 = json_encode('success',JSON_UNESCAPED_UNICODE ); 
     /* fetch associative array */

   }else
   {$result2 = json_encode('echec',JSON_UNESCAPED_UNICODE );} 
   echo ($result2);
 }
	//----------------------------liste adresse---------------------
	if ( $_REQUEST['cmd']=='liste_adresse')
       {
        $data = [];
        $sql1="SELECT * FROM adresse ";
        if ($result = $conn->query($sql1)) {

          while ($row = $result->fetch_assoc()) {

            array_push($data, $row);
          }}
          $result = json_encode($data,JSON_UNESCAPED_UNICODE ); 

          echo ($result);
        }
		//----------------------------liste demande agent---------------------
			if ( $_REQUEST['cmd']=='liste_demande_agent')
       {
		 
        $data = [];
        $sql1="SELECT X.*,(SELECT C.nom_raisonsociale FROM `compte` C INNER JOIN client Cl where C.id=Cl.id_compte and Cl.id=(select client from demandes where id=X.id)) as 'nom_client' FROM demandes X 
		where X.etat='validation par lagent' or X.etat='Valider'";
      
		if ($result = $conn->query($sql1)) {
			
          while ($row = $result->fetch_assoc()) {
		
            array_push($data, $row);
          }}
          $result = json_encode($data,JSON_UNESCAPED_UNICODE ); 

          echo ($result);
        }
		
		//----------------------------liste demande Technicien---------------------
			if ( $_REQUEST['cmd']=='liste_demande_technicien')
       {
        $data = [];
        $sql1="SELECT X.*,(SELECT CO.nom_raisonsociale FROM `client` C INNER JOIN compte CO on Co.id = C.id_compte where C.id = X.id  ) as 'nom_client' FROM demandes X 
		where X.etat='validation par la technicien' or X.etat='valider' or X.etat='validation de offre'  ";
        if ($result = $conn->query($sql1)) {

          while ($row = $result->fetch_assoc()) {

            array_push($data, $row);
          }}
          $result = json_encode($data,JSON_UNESCAPED_UNICODE ); 

          echo ($result);
        }
		//----------------------------liste contrat Technicien---------------------
			if ( $_REQUEST['cmd']=='liste_contrat_technicien')
       {
        $data = [];
        $sql1="SELECT * from contrat";
        if ($result = $conn->query($sql1)) {

          while ($row = $result->fetch_assoc()) {

            array_push($data, $row);
          }}
          $result = json_encode($data,JSON_UNESCAPED_UNICODE ); 

          echo ($result);
        }//----------------------------liste contrat Technicien---------------------
			if ( $_REQUEST['cmd']=='liste_contrat')
       {
        $data = [];
        $sql1="SELECT X.*,(SELECT D.marchandise FROM `demandes` D INNER JOIN contrat C on D.id = C.id_demande where C.id = X.id ) as 'demande1' from contrat X";
        if ($result = $conn->query($sql1)) {

          while ($row = $result->fetch_assoc()) {

            array_push($data, $row);
          }}
          $result = json_encode($data,JSON_UNESCAPED_UNICODE ); 

          echo ($result);
        }
		//----------------------------liste demande directeur---------------------
			if ( $_REQUEST['cmd']=='liste_demande_directeur')
       {
        $data = [];
        $sql1="SELECT X.*,(SELECT CO.nom_raisonsociale FROM `client` C INNER JOIN compte CO on Co.id = C.id_compte where C.id = X.id  ) as 'nom_client' FROM demandes X 
		where X.etat='validation par le directeur' or X.etat='valider'";
        if ($result = $conn->query($sql1)) {

          while ($row = $result->fetch_assoc()) {

            array_push($data, $row);
          }}
          $result = json_encode($data,JSON_UNESCAPED_UNICODE ); 

          echo ($result);
        }
	//register
	 if ( $_REQUEST['cmd']=='register')
        {
		
        $identifiant = $_REQUEST['identifiant'];
        $motdepasse = $_REQUEST['motdepasse'];
	$type_personne = $_REQUEST['type_personne'];
	$name=$_REQUEST['nom'];
		echo($identifiant ); 
		echo($motdepasse );
	$sql2="INSERT INTO `compte`( `nom_raisonsociale`,`identifiant`, `motdepasse`, `id_service`, `role`,`type_personne`) VALUES ('$name','$identifiant','$motdepasse',null,0,'$type_personne')";
       // $sql2="INSERT INTO `compte`( `nom/raisonsociale`,`identifiant`, `motdepasse`, `id_service`, `role`) VALUES ('$nom','$identifiant','$motdepasse',(SELECT id from service where id=1),0)";
            // $res1 = $conn->query($sql1) or die($conn->error);
                     //if ($result = $conn->query($sql1)) 
        if ($result2 = $conn->query($sql2)) {
         $result2 = json_encode('success',JSON_UNESCAPED_UNICODE ); 
         /* fetch associative array */

       }else
       {$result2 = json_encode('echec',JSON_UNESCAPED_UNICODE );} 
		echo ($result2);
     }
	 //ajout compte
	 if ( $_REQUEST['cmd']=='ajout_compte1')
        {
        $identifiant = $_REQUEST['identifiant'];   
        $motdepasse = $_REQUEST['motdepasse'];
		$id_service = $_REQUEST['id_service'];
		$role = $_REQUEST['role'];
		$type_personne = $_REQUEST['type_personne'];
		echo($identifiant );
		echo($motdepasse );
		$name= $_REQUEST['name'];
	$sql2="INSERT INTO `compte`(`nom_raisonsociale`, `identifiant`, `motdepasse`, `id_service`, `role`, `type_personne`) VALUES ('$name','$identifiant','$motdepasse',(select id from service where id=$id_service),$role,$type_personne)";
       // $sql2="INSERT INTO `compte`( `nom/raisonsociale`,`identifiant`, `motdepasse`, `id_service`, `role`) VALUES ('$nom','$identifiant','$motdepasse',(SELECT id from service where id=1),0)";
            // $res1 = $conn->query($sql1) or die($conn->error);
                     //if ($result = $conn->query($sql1)) 
        if ($result2 = $conn->query($sql2)) {
         $result2 = json_encode('success',JSON_UNESCAPED_UNICODE ); 
         /* fetch associative array */

       }else
       {$result2 = json_encode('echec',JSON_UNESCAPED_UNICODE );} 
		echo ($result2);
     }
	  //modifier compte
	 if ( $_REQUEST['cmd']=='modifier_compte1')
        {
        $identifiant = $_REQUEST['identifiant'];   
        $motdepasse = $_REQUEST['motdepasse'];
		$id_service = $_REQUEST['id_service'];
		$id = $_REQUEST['id'];
		$role = $_REQUEST['role'];
		$type_personne = $_REQUEST['type_personne'];
		echo($identifiant );
		echo($motdepasse );$name= $_REQUEST['name'];
	$sql2="UPDATE `compte` SET `nom_raisonsociale`='$name'
	, `identifiant`='$identifiant'
	 ,`motdepasse`='$motdepasse'
	 , `id_service`=(select id from service where id=$id_service)
	 , `role`=$role
	 , `type_personne`=$type_personne Where id=$id
	 ";
       // $sql2="INSERT INTO `compte`( `nom/raisonsociale`,`identifiant`, `motdepasse`, `id_service`, `role`) VALUES ('$nom','$identifiant','$motdepasse',(SELECT id from service where id=1),0)";
            // $res1 = $conn->query($sql1) or die($conn->error);
                     //if ($result = $conn->query($sql1)) 
        if ($result2 = $conn->query($sql2)) {
         $result2 = json_encode('success',JSON_UNESCAPED_UNICODE ); 
         /* fetch associative array */

       }else
       {$result2 = json_encode('echec',JSON_UNESCAPED_UNICODE );} 
		echo ($result2);
     }
	  //modifier mot de passe profile
	 if ( $_REQUEST['cmd']=='modifier_compte3')
        {  
        $motdepasse = $_REQUEST['motdepasse'];
		$id = $_REQUEST['id'];
		echo($motdepasse );
	$sql2="UPDATE `compte` SET `motdepasse`='$motdepasse'  Where id=$id ";
        if ($result2 = $conn->query($sql2)) {
         $result2 = json_encode('success',JSON_UNESCAPED_UNICODE ); 
       }else
       {$result2 = json_encode('echec',JSON_UNESCAPED_UNICODE );} 
		echo ($result2);
     }
	//Verification
	
    if ( $_REQUEST['cmd']=='verif_login')
    { $identifiant = $_REQUEST['identifiant'];
    $motdepasse = $_REQUEST['motdepasse'];$data = [];
      $sql1="SELECT *,'emp' as nature FROM compte WHERE identifiant='$identifiant' and motdepasse='$motdepasse' ";
	    $sql2="SELECT *,'clt' as nature FROM client WHERE identifiant='$identifiant' and motdepasse='$motdepasse' ";
		$result = $conn->query($sql1);
		$result2 = $conn->query($sql2);
     if ($result->num_rows>0) {
        $row = $result->fetch_assoc();
		$data=$row;
		        $result = json_encode($data,JSON_UNESCAPED_UNICODE ); 
		}
		
		
		else  if ($result2->num_rows>0) {
		
        $row2 = $result2->fetch_assoc();
		$data=$row2;
				        $result = json_encode($data,JSON_UNESCAPED_UNICODE ); 

		}else
			$result = json_encode(null,JSON_UNESCAPED_UNICODE ); 
		 echo ($result);

       
    }
	//Verification register
	
    if ( $_REQUEST['cmd']=='verif_login_reg')
    { $identifiant = $_REQUEST['identifiant'];
    $data = [];
      $sql1="SELECT *,'emp' as nature FROM compte WHERE identifiant='$identifiant' ";
		$result = $conn->query($sql1);
      if ($result->num_rows>0) {
        $row = $result->fetch_assoc();
		$data=$row;
		        $result = json_encode($data,JSON_UNESCAPED_UNICODE ); 

		}
		else
			$result = json_encode(null,JSON_UNESCAPED_UNICODE ); 
		 echo ($result);
	

    }
	//-----------------verif personne---------------
	 if ( $_REQUEST['cmd']=='verif_personne')
    { $id = $_REQUEST['id'];
     $data = [];
      $sql1="select id from client where id_compte=(select id from compte where id=$id)";
	if ($result = $conn->query($sql1)) {

          while ($row = $result->fetch_assoc()) {

            array_push($data, $row);
          }}
	
         if($data!=null)
		  {
          $result = json_encode(2,JSON_UNESCAPED_UNICODE ); }
             else
		  {
          $result = json_encode(1,JSON_UNESCAPED_UNICODE ); }
		  
          echo ($result);
        }
    /* if($data!=null)
		  {
          $result = json_encode(2,JSON_UNESCAPED_UNICODE ); }
             else
		  {
          $result = json_encode(1,JSON_UNESCAPED_UNICODE ); }*/
//Modifier demande
if ( $_REQUEST['cmd']=='modifier_demande')
       {
        $id= $_REQUEST['id'];
        $etat = $_REQUEST['etat'];
        $sql2="UPDATE `demandes` SET `etat`='$etat' WHERE id='$id'";
  				  // $res1 = $conn->query($sql1) or die($conn->error);
                     //if ($result = $conn->query($sql1)) 
        if ($result2 = $conn->query($sql2)) {
         $result2 = json_encode('success',JSON_UNESCAPED_UNICODE ); }
         else
           {$result2 = json_encode('echec',JSON_UNESCAPED_UNICODE );} 
         echo ($result2);
       }
	   
    // $email = $_REQUEST['email'];
    // $motdepasse = $_REQUEST['motdepasse'];

    // if ( $_REQUEST['cmd']=='agent')
    // { $data = [];
      // $sql1="SELECT * FROM compte WHERE email='$email' and motdepasse='$motdepasse' and id_service=1";
      // if ($result = $conn->query($sql1)) {

        // while ($row = $result->fetch_assoc()) {

          // array_push($data, $row);
        // }}

        // $result = json_encode($data,JSON_UNESCAPED_UNICODE ); 

        // echo ($result);
      // }
// Affichage Technicien

    // $email = $_REQUEST['email'];
    // $motdepasse = $_REQUEST['motdepasse'];

    // if ( $_REQUEST['cmd']=='technicien')
    // { $data = [];
      // $sql1="SELECT * FROM compte WHERE email='$email' and motdepasse='$motdepasse' and id_service=2";
      // if ($result = $conn->query($sql1)) {

        // while ($row = $result->fetch_assoc()) {

          // array_push($data, $row);
        // }}

        // $result = json_encode($data,JSON_UNESCAPED_UNICODE ); 

        // echo ($result);
      // }
      // Affichage Directeur

    // $email = $_REQUEST['email'];
    // $motdepasse = $_REQUEST['motdepasse'];

    // if ( $_REQUEST['cmd']=='directeur')
    // { $data = [];
      // $sql1="SELECT * FROM compte WHERE email='$email' and motdepasse='$motdepasse' and id_service=3";
      // if ($result = $conn->query($sql1)) {

        // while ($row = $result->fetch_assoc()) {

          // array_push($data, $row);
        // }}

        // $result = json_encode($data,JSON_UNESCAPED_UNICODE ); 

        // echo ($result);
      // }
	  //Ajout contrat
	  if ( $_REQUEST['cmd']=='ajouter_contrat')
        {
          $titre = $_REQUEST['titre'];
          $demande = $_REQUEST['demande'];
          $sql2="INSERT INTO `contrat`(`titre`,`etat`,`client`,`adresse`,`marchandise`,`nature_de_transport`,`offre`,`id_demande`) VALUES ('$titre','en cours de preparation',
		  (select nom_raisonsociale from compte where id =(select id_compte from client where id=(select client from demandes where id=$demande))),
		  (select adresse from client where id=(select client from demandes where id=$demande)),
		  (select marchandise from demandes where id=$demande),
		  (select nature_de_transport from demandes where id=$demande),
		  (select offre from demandes where id=$demande),
		  (select id from demandes where id=$demande))";
  				  // $res1 = $conn->query($sql1) or die($conn->error);
                     //if ($result = $conn->query($sql1)) 
          if ($result2 = $conn->query($sql2)) {
           $result2 = json_encode('success',JSON_UNESCAPED_UNICODE ); 
           /* fetch associative array */

         }else
         {$result2 = json_encode('echec',JSON_UNESCAPED_UNICODE );} 
         echo ($result2);
       }
	   //Modifier contrat
	  if ( $_REQUEST['cmd']=='modifier_contrat')
        {//en cours de preparation
          $etat = $_REQUEST['etat'];
		  $id= $_REQUEST['id'];
          $sql2="UPDATE `contrat` SET `etat`='$etat' WHERE id=$id";
  				  // $res1 = $conn->query($sql1) or die($conn->error);
                     //if ($result = $conn->query($sql1)) 
          if ($result2 = $conn->query($sql2)) {
           $result2 = json_encode('success',JSON_UNESCAPED_UNICODE ); 
           /* fetch associative array */

         }else
         {$result2 = json_encode('echec',JSON_UNESCAPED_UNICODE );} 
         echo ($result2);
       }
	   //Affichage Contrat 
 if ( $_REQUEST['cmd']=='liste_contrat_imprimer')
       {
        $data = [];
        $sql1="SELECT  X.*,(SELECT D.marchandise FROM `demandes` D INNER JOIN contrat C on D.id = C.id_demande where C.id = X.id ) as 'demande1' from contrat X";
        if ($result = $conn->query($sql1)) {

          while ($row = $result->fetch_assoc()) {

            array_push($data, $row);
          }}
          $result = json_encode($data,JSON_UNESCAPED_UNICODE ); 

          echo ($result);
        }

//-------------------------------------------------crud service-----------------------------------------------
//Affichage service
 if ( $_REQUEST['cmd']=='liste_service')
       {
        $data = [];
        $sql1="SELECT * FROM service";
        if ($result = $conn->query($sql1)) {

          while ($row = $result->fetch_assoc()) {

            array_push($data, $row);
          }}
          $result = json_encode($data,JSON_UNESCAPED_UNICODE ); 

          echo ($result);
        }
//Ajout service
        if ( $_REQUEST['cmd']=='ajouter_service')
        {
          $titre = $_REQUEST['titre'];
          $sql2="INSERT INTO `service`(`titre`) VALUES ('$titre')";
  				  // $res1 = $conn->query($sql1) or die($conn->error);
                     //if ($result = $conn->query($sql1)) 
          if ($result2 = $conn->query($sql2)) {
           $result2 = json_encode('success',JSON_UNESCAPED_UNICODE ); 
           /* fetch associative array */

         }else
         {$result2 = json_encode('echec',JSON_UNESCAPED_UNICODE );} 
         echo ($result2);
       }
//Modification service
       if ( $_REQUEST['cmd']=='modifier_service')
       {
        $titre = $_REQUEST['titre'];
        $id = $_REQUEST['id'];
        $sql2="UPDATE `service` SET `titre`='$titre' WHERE id='$id'";
  				  // $res1 = $conn->query($sql1) or die($conn->error);
                     //if ($result = $conn->query($sql1)) 
        if ($result2 = $conn->query($sql2)) {
         $result2 = json_encode('success',JSON_UNESCAPED_UNICODE ); }
         else
           {$result2 = json_encode('echec',JSON_UNESCAPED_UNICODE );} 
         echo ($result2);
       }
//Supression service
       if ( $_REQUEST['cmd']=='supprimer_service')
       {
        $id = $_REQUEST['id'];
        $sql2="DELETE FROM `service` WHERE id='$id'";
  				  // $res1 = $conn->query($sql1) or die($conn->error);
                     //if ($result = $conn->query($sql1)) 
        if ($result2 = $conn->query($sql2)) {
         $result2 = json_encode('success',JSON_UNESCAPED_UNICODE );}
         else
           {$result2 = json_encode('echec',JSON_UNESCAPED_UNICODE );} 
         echo ($result2);
       }
//-------------------------------------------------crud client-------------------------------------------------
       if ( $_REQUEST['cmd']=='idd_client')
       {
        $data = [];
        $sql1="SELECT id FROM client";
        if ($result = $conn->query($sql1)) {

          while ($row = $result->fetch_assoc()) {

            array_push($data, $row);
          }}
          $result = json_encode($data,JSON_UNESCAPED_UNICODE ); 

          echo ($result);
        }
//Affichage Client
       if ( $_REQUEST['cmd']=='liste_client')
       {
        $data = [];
        $sql1="SELECT * FROM client";
        if ($result = $conn->query($sql1)) {

          while ($row = $result->fetch_assoc()) {

            array_push($data, $row);
          }}
          $result = json_encode($data,JSON_UNESCAPED_UNICODE ); 

          echo ($result);
        }
		/*//ajout_client3
		 if ( $_REQUEST['cmd']=='ajout_client')
          {$type_personne = $_REQUEST['type_personne'];
        $Identifiant = $_REQUEST['Identifiant'];
        $motdepasse = $_REQUEST['motdepasse'];
		$id_compte=$_REQUEST['id_compte'];
		$type_adresse=$_REQUEST['type_adresse'];
		$langue=$_REQUEST['langue'];
		$adresse=$_REQUEST['adresse'];
		$ville=$_REQUEST['ville'];
		$region_codepostale=$_REQUEST['region_codepostale'];
		$pays=$_REQUEST['pays'];
		$numero_domicile=$_REQUEST['numero_domicile'];
		$numero_travail=$_REQUEST['numero_travail'];
		$numero_telex=$_REQUEST['numero_telex'];
		$numero_fax=$_REQUEST['numero_fax'];
		$numero_cellulaire=$_REQUEST['numero_cellulaire'];
		$courrier_electro=$_REQUEST['courrier_electro'];
        $sql2="INSERT INTO `client`(`type_personne`,`type_adresse`, `langue`, `adresse`, `ville`, `region_codepostale`, `pays`, `numero_domicile`,
		`numero_travail`, `numero_telex`, `numero_fax`, `numero_cellulaire`, `courrier-electro`, `Identifiant`, `motdepasse`, `id_compte`) 
		VALUES ('$type_personne',`$type_adresse`, `$langue`, `$adresse`, `$ville`, `$region_codepostale`, `$pays`, `$numero_domicile`,
		`$numero_travail`, `$numero_telex`, `$numero_fax`, `$numero_cellulaire`, `$courrier_electro`,'$Identifiant','$motdepasse',(SELECT id FROM compte WHERE id=$id_compte))";
            // $res1 = $conn->query($sql1) or die($conn->error);
                     //if ($result = $conn->query($sql1)) 
        if ($result2 = $conn->query($sql2)) {
         $result2 = json_encode('success',JSON_UNESCAPED_UNICODE ); 
         /* fetch associative array 

       }else
       {$result2 = json_encode('echec',JSON_UNESCAPED_UNICODE );} 
       echo ($result2);
     }*/
//
//inserion Client
        if ( $_REQUEST['cmd']=='ajout_client')
          {$type_personne = $_REQUEST['type_personne'];
        $Identifiant = $_REQUEST['Identifiant'];
        $motdepasse = $_REQUEST['motdepasse'];
		$id_compte=$_REQUEST['id_compte'];
		$type_adresse=$_REQUEST['type_adresse'];
		$langue=$_REQUEST['langue'];
		$adresse=$_REQUEST['adresse'];
		$ville=$_REQUEST['ville'];
		$region_codepostale=$_REQUEST['region_codepostale'];
		$pays=$_REQUEST['pays'];
		$numero_domicile=$_REQUEST['numero_domicile'];
		$numero_travail=$_REQUEST['numero_travail'];
		$numero_telex=$_REQUEST['numero_telex'];
		$numero_fax=$_REQUEST['numero_fax'];
		$numero_cellulaire=$_REQUEST['numero_cellulaire'];
		$courrier_electro=$_REQUEST['courrier_electro'];
        $sql2="INSERT INTO `client`(`type_personne`,`type_adresse`, `langue`, `adresse`, `ville`, `region_codepostale`, `pays`, `numero_domicile`,
		`numero_travail`, `numero_telex`, `numero_fax`, `numero_cellulaire`, `courrier_electro`, `Identifiant`, `motdepasse`, `id_compte`) 
		VALUES ('$type_personne','$type_adresse', '$langue', '$adresse', '$ville', '$region_codepostale', '$pays', '$numero_domicile',
		'$numero_travail', '$numero_telex', '$numero_fax', '$numero_cellulaire', '$courrier_electro','$Identifiant','$motdepasse',(SELECT id FROM compte WHERE id=$id_compte))";
            // $res1 = $conn->query($sql1) or die($conn->error);
                     //if ($result = $conn->query($sql1)) 
        if ($result2 = $conn->query($sql2)) {
         $result2 = json_encode('success',JSON_UNESCAPED_UNICODE ); 
         /* fetch associative array */

       }else
       {$result2 = json_encode('echec',JSON_UNESCAPED_UNICODE );} 
       echo ($result2);
     }
//Modification Client
     if ( $_REQUEST['cmd']=='modifier_client')
      { $id = $_REQUEST['id'];
    $nom = $_REQUEST['nom'];
    $prenom = $_REQUEST['prenom'];
    $email = $_REQUEST['email'];
    $motdepasse = $_REQUEST['motdepasse'];
    $sql2="UPDATE `client` SET `nom`='$nom',`prenom`='$prenom',`email`='$email',`motdepasse`='$motdepasse' WHERE `id`='$id'";
            // $res1 = $conn->query($sql1) or die($conn->error);
                     //if ($result = $conn->query($sql1)) 
    if ($result2 = $conn->query($sql2)) {
     $result2 = json_encode('success',JSON_UNESCAPED_UNICODE ); 
     /* fetch associative array */

   }else
   {$result2 = json_encode('echec',JSON_UNESCAPED_UNICODE );} 
   echo ($result2);
 }
//Supression client
 if ( $_REQUEST['cmd']=='supprimer_client')
 {
  $id = $_REQUEST['id'];
  $sql2="DELETE FROM `client` WHERE id='$id'";
            // $res1 = $conn->query($sql1) or die($conn->error);
                     //if ($result = $conn->query($sql1)) 
  if ($result2 = $conn->query($sql2)) {
   $result2 = json_encode('success',JSON_UNESCAPED_UNICODE );}
   else
     {$result2 = json_encode('echec',JSON_UNESCAPED_UNICODE );} 
   echo ($result2);
 }
     //-------------------------------------------------crud produit-------------------------------------------------
//Affichage personne morale
 if ( $_REQUEST['cmd']=='liste_pesonne_morale')
 {
  $data = [];
  $sql1="SELECT X.*,(SELECT C.nom_raisonsociale FROM `compte` C INNER JOIN client Cl where C.id=Cl.id_compte and Cl.id=(select id_client from personne_morale where id=X.id)) as 'nom_client'FROM personne_morale X";
  if ($result = $conn->query($sql1)) {

    while ($row = $result->fetch_assoc()) {

      array_push($data, $row);
    }}
    $result = json_encode($data,JSON_UNESCAPED_UNICODE ); 

    echo ($result);
  }
  //Affichage personne physique
 if ( $_REQUEST['cmd']=='liste_pesonne_physique')
 {
  $data = [];
  $sql1="SELECT X.* ,(SELECT C.nom_raisonsociale FROM `client` C INNER JOIN personnes_physique p on C.id = p.id_client where p.id = X.id) as 'nom_client'FROM personnes_physique X";
  if ($result = $conn->query($sql1)) {

    while ($row = $result->fetch_assoc()) {

      array_push($data, $row);
    }}
    $result = json_encode($data,JSON_UNESCAPED_UNICODE ); 

    echo ($result);
  }
//Ajout personne morale
  if ( $_REQUEST['cmd']=='ajout_personne_morale1')
  {
    $raison_sociale=$_REQUEST['raison_sociale'];
$abreviation=$_REQUEST['abreviation'];
$pays=$_REQUEST['pays'];
$nature_affaire=$_REQUEST['nature_affaire'];
$type_organisation=$_REQUEST['type_organisation'];
$physique_morale=$_REQUEST['physique_morale'];
$n_register_commerce=$_REQUEST['n_register_commerce'];
$matricule_fiscale=$_REQUEST['matricule_fiscale'];
$capitale_sociale=$_REQUEST['capitale_sociale'];
$assujiti_a_taxe=$_REQUEST['assujiti_a_taxe'];
$effective=$_REQUEST['effective'];
$langue=$_REQUEST['langue'];
$chiffre_affaire=$_REQUEST['chiffre_affaire'];
$id=$_REQUEST['id'];
    $sql2="INSERT INTO `personne_morale` (`raison_sociale`, `abreviation`, `pays`, `nature_affaire`, `type_organisation`,
	`physique_morale`, `n_register_commerce`, `matricule_fiscale`, `capitale_sociale`, `assujiti_a_taxe`, `effective`, `langue`, 
	`chiffre_affaire`, `id_client`) VALUES  ('$raison_sociale', '$abreviation', '$pays', '$nature_affaire', '$type_organisation',
	'$physique_morale', '$n_register_commerce', '$matricule_fiscale', '$capitale_sociale', '$assujiti_a_taxe', '$effective', '$langue', 
	$chiffre_affaire,(select id from client where id_compte=(select id from compte where id=$id)))";
           
    if ($result2 = $conn->query($sql2)) {
     $result2 = json_encode('success',JSON_UNESCAPED_UNICODE ); 
     /* fetch associative array */

   }else
   {$result2 = json_encode('echec',JSON_UNESCAPED_UNICODE );} 
   echo ($result2);
 }
 //Ajout adresse
  if ( $_REQUEST['cmd']=='ajout_adresse')
  {
    $type_adresse=$_REQUEST['type_adresse'];
$langue=$_REQUEST['langue'];
$adresse=$_REQUEST['adresse'];
$ville=$_REQUEST['ville'];
$region_codepostale=$_REQUEST['region_codepostale'];
$pays=$_REQUEST['pays'];
$numero_domicile=$_REQUEST['numero_domicile'];
$numero_travail=$_REQUEST['numero_travail'];
$numero_telex=$_REQUEST['numero_telex'];
 $numero_fax=$_REQUEST['numero_fax'];
$numero_cellulaire=$_REQUEST['numero_cellulaire'];
$courrier_electro=$_REQUEST['courrier_electro'];

$id=$_REQUEST['id'];
    $sql2= "INSERT INTO `adresse`( `type_adresse`, `langue`, `adresse`, `ville`, `region_codepostale`, `pays`, `numero_domicile`,
 `numero_travail`, `numero_telex`, `numero_fax`, `numero_cellulaire`, `courrier_electro`, `id_client`) VALUES 
 ( '$type_adresse', '$langue', '$adresse', '$ville', '$region_codepostale', '$pays',$numero_domicile,
 $numero_travail,$numero_telex,$numero_fax,$numero_cellulaire,'$courrier_electro',
 (select id from client where id_compte=(select id from compte where id=$id)))";
            // $res1 = $conn->query($sql1) or die($conn->error);
                     //if ($result = $conn->query($sql1)) 
    if ($result2 = $conn->query($sql2)) {
     $result2 = json_encode('success',JSON_UNESCAPED_UNICODE ); 
     /* fetch associative array */

   }else
   {$result2 = json_encode('echec',JSON_UNESCAPED_UNICODE );} 
   echo ($result2);
 }
//Ajout personne morale
  if ( $_REQUEST['cmd']=='modifier_personne_morale')
  {
    $raison_sociale=$_REQUEST['raison_sociale'];
$abreviation=$_REQUEST['abreviation'];
$pays=$_REQUEST['pays'];
$nature_affaire=$_REQUEST['nature_affaire'];
$type_organisation=$_REQUEST['type_organisation'];
$physique_morale=$_REQUEST['physique_morale'];
$n_register_commerce=$_REQUEST['n_register_commerce'];
$matricule_fiscale=$_REQUEST['matricule_fiscale'];
$capitale_sociale=$_REQUEST['capitale_sociale'];
$assujiti_a_taxe=$_REQUEST['assujiti_a_taxe'];
$effective=$_REQUEST['effective'];
$langue=$_REQUEST['langue'];
$chiffre_affaire=$_REQUEST['chiffre_affaire'];
$id=$_REQUEST['id'];
    $sql2="UPDATE `personne_morale` SET `raison_sociale`='$raison_sociale',`abreviation`='$abreviation',
	`pays`='$pays',`nature_affaire`='$nature_affaire',`type_organisation`='$type_organisation',`physique_morale`='$physique_morale',
	`n_register_commerce`='$n_register_commerce',`matricule_fiscale`='$matricule_fiscale',`capitale_sociale`='$capitale_sociale',`assujiti_a_taxe`='$assujiti_a_taxe',
	`effective`='$effective',`langue`='$langue',`chiffre_affaire`='$chiffre_affaire'
	WHERE `id_client`=(select id from client where id_compte=(select id from compte where id=$id))";
           
    if ($result2 = $conn->query($sql2)) {
     $result2 = json_encode('success',JSON_UNESCAPED_UNICODE ); 
     /* fetch associative array */

   }else
   {$result2 = json_encode('echec',JSON_UNESCAPED_UNICODE );} 
   echo ($result2);
 }//Ajout personne morale
  if ( $_REQUEST['cmd']=='modifier_adresse')
  {
    $type_adresse=$_REQUEST['type_adresse'];
$langue=$_REQUEST['langue'];
$adresse=$_REQUEST['adresse'];
$ville=$_REQUEST['ville'];
$region_codepostale=$_REQUEST['region_codepostale'];
$pays=$_REQUEST['pays'];
$numero_domicile=$_REQUEST['numero_domicile'];
$numero_travail=$_REQUEST['numero_travail'];
$numero_telex=$_REQUEST['numero_telex'];
 $numero_fax=$_REQUEST['numero_fax'];
$numero_cellulaire=$_REQUEST['numero_cellulaire'];
$courrier_electro=$_REQUEST['courrier_electro'];

$id=$_REQUEST['id'];
    $sql2= "UPDATE `adresse`SET `type_adresse`='$type_adresse', `langue`='$langue', `adresse`='$adresse', `ville`='$ville', 
	`region_codepostale`='$region_codepostale', `pays`='$pays', `numero_domicile`='$numero_domicile',
 `numero_travail`='$numero_travail', `numero_telex`='$numero_telex', `numero_fax`='$numero_fax', `numero_cellulaire`='$numero_cellulaire'
  ,`courrier_electro`='$courrier_electro'
 WHERE `id_client`=(select id from client where id_compte=(select id from compte where id=$id))";
   // $res1 = $conn->query($sql1) or die($conn->error);
                     //if ($result = $conn->query($sql1)) 
    if ($result2 = $conn->query($sql2)) {
     $result2 = json_encode('success',JSON_UNESCAPED_UNICODE ); 
     /* fetch associative array */

   }else
   {$result2 = json_encode('echec',JSON_UNESCAPED_UNICODE );} 
   echo ($result2);
 }

//inserion Demande
        if ( $_REQUEST['cmd']=='ajouter_demande')
          {$titre = $_REQUEST['titre'];
        $sql2="INSERT INTO `demandes`(`titre`, `etat`, `client`) VALUES ('$titre','en cours de traitement','1')";
            // $res1 = $conn->query($sql1) or die($conn->error);
                     //if ($result = $conn->query($sql1)) 
        if ($result2 = $conn->query($sql2)) {
         $result2 = json_encode('success',JSON_UNESCAPED_UNICODE ); 
         /* fetch associative array */

       }else
       {$result2 = json_encode('echec',JSON_UNESCAPED_UNICODE );} 
       echo ($result2);
     }
//affichage Demande
	if ( $_REQUEST['cmd']=='liste_demande')
 {
  $data = [];
  $sql1="SELECT X.*,(SELECT C.nom_raisonsociale FROM `compte` C INNER JOIN client Cl where C.id=Cl.id_compte and Cl.id=(select client from demandes where id=X.id)) as 'nom_client' FROM demandes X";
  if ($result = $conn->query($sql1)) {

    while ($row = $result->fetch_assoc()) {

      array_push($data, $row);
    }}
    $result = json_encode($data,JSON_UNESCAPED_UNICODE ); 

    echo ($result);
  }
  //affichage Demande de client
 if ( $_REQUEST['cmd']=='liste_demande_client')
 {$id=$_REQUEST['id'];
  $data = [];
 
  $sql1="SELECT * FROM demandes where client=(select id from client where id_compte=(select id from compte where id=$id))";
  if ($result = $conn->query($sql1)) {

    while ($row = $result->fetch_assoc()) {

      array_push($data, $row);
    }}
    $result = json_encode($data,JSON_UNESCAPED_UNICODE ); 

    echo ($result);
  }
    //affichage Demande de client en cours
 if ( $_REQUEST['cmd']=='select_demande_client_encour')
 {$id=$_REQUEST['id'];
  $data = [];
  
 $etat='en cours de validation par lagent';
  $sql1="SELECT id,groupe_marchandise,etat,client FROM demandes where client=(select id from client where id_compte=(select id from compte where id=$id)) and etat='$etat'";
  if ($result = $conn->query($sql1)) {

    while ($row = $result->fetch_assoc()) {

      array_push($data, $row);
    }}
    
if ($data>0)
{$result =""; }
else{$result ="hhh"; }
echo ($result);

  }
//Modification Demande

 if ( $_REQUEST['cmd']=='modifier_demande_client')
 {
  $data = [];
$mmatriculation=$_REQUEST['mmatriculation'];
$groupe_marchandise=$_REQUEST['groupe_marchandise'];
$marchandise=$_REQUEST['marchandise'];
$territorialite=$_REQUEST['territorialite'];
$nature_de_transport=$_REQUEST['nature_de_transport'];
$capital_assure_par_vehicule=$_REQUEST['capital_assure_par_vehicule'];
$nature_moyen_de_transport=$_REQUEST['nature_moyen_de_transport'];
$type_moyen_de_transport=$_REQUEST['type_moyen_de_transport'];
$etat=$_REQUEST['etat'];
$id=$_REQUEST['id'];
$id_dem=$_REQUEST['id_dem'];

 $sql2="UPDATE `demandes` SET `mmatriculation`='$mmatriculation',`groupe_marchandise`='$groupe_marchandise',
 `marchandise`='$marchandise',`territorialite`='$territorialite',`nature_de_transport`='$nature_de_transport',
 `capital_assure_par_vehicule`='$capital_assure_par_vehicule' ,
 `nature_moyen_de_transport`='$nature_moyen_de_transport',`type_moyen_de_transport`='$type_moyen_de_transport',
 `etat`='$etat'
 WHERE id=$id_dem";
            // $res1 = $conn->query($sql1) or die($conn->error);
                     //if ($result = $conn->query($sql1)) 
  if ($result2 = $conn->query($sql2)) {
   $result2 = json_encode('success',JSON_UNESCAPED_UNICODE ); }
   else
     {$result2 = json_encode('echec',JSON_UNESCAPED_UNICODE );} 
   echo ($result2);
 }
 //Ajout Demande

 if ( $_REQUEST['cmd']=='ajout_demande_client')
 {
  $data = [];
$mmatriculation=$_REQUEST['mmatriculation'];
$groupe_marchandise=$_REQUEST['groupe_marchandise'];
$marchandise=$_REQUEST['marchandise'];
$territorialite=$_REQUEST['territorialite'];
$nature_de_transport=$_REQUEST['nature_de_transport'];
$capital_assure_par_vehicule=$_REQUEST['capital_assure_par_vehicule'];
$nature_moyen_de_transport=$_REQUEST['nature_moyen_de_transport'];
$type_moyen_de_transport=$_REQUEST['type_moyen_de_transport'];
$etat=$_REQUEST['etat'];
$date_creation=$_REQUEST['date_creation'];
$id=$_REQUEST['id'];
 $sql2="INSERT INTO `demandes`(`mmatriculation`, `groupe_marchandise`, `marchandise`, `territorialite`, `nature_de_transport`, 
 `capital_assure_par_vehicule`, `nature_moyen_de_transport`, `type_moyen_de_transport`, `etat`,`date_creation`,`offre`, `client`)
 VALUES ('$mmatriculation', '$groupe_marchandise', '$marchandise', 
 '$territorialite', '$nature_de_transport', '$capital_assure_par_vehicule' ,'$nature_moyen_de_transport',
 '$type_moyen_de_transport','$etat','$date_creation','0', (select id from client where id_compte=(select id from compte where id=$id)))";
    //  $sql2="INSERT INTO `demandes`(`titre`, `etat`, `client`) VALUES ('$titre','en cours de traitement','$id')";

            
  if ($result2 = $conn->query($sql2)) {
   $result2 = json_encode('success',JSON_UNESCAPED_UNICODE ); }
  else
     {$result2 = json_encode('echec',JSON_UNESCAPED_UNICODE );} 
   echo ($result2);
 }
 //Annulation Demande
 if ( $_REQUEST['cmd']=='annuler_demande_client')
 {
  $data = [];
$id_dem= $_REQUEST['id_dem'];
  
  $sql2="UPDATE `demandes` SET `etat`='la demande annuler par client' WHERE id='$id_dem'";
            // $res1 = $conn->query($sql1) or die($conn->error);
                     //if ($result = $conn->query($sql1)) 
  if ($result2 = $conn->query($sql2)) {
   $result2 = json_encode('success',JSON_UNESCAPED_UNICODE ); }
   else
     {$result2 = json_encode('echec',JSON_UNESCAPED_UNICODE );} 
   echo ($result2);
 }
 $conn->close();
 ?>
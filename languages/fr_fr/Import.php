<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
$languageStrings = array(
	'LBL_IMPORT_STEP_1'            => 'Etape 1'                     , 
	'LBL_IMPORT_STEP_1_DESCRIPTION' => 'Choix du fichier'            , 
	'LBL_IMPORT_SUPPORTED_FILE_TYPES' => 'Types de fichier supportés: .CSV, .VCF', 
	'LBL_IMPORT_STEP_2'            => 'Etape 2'                     , 
	'LBL_IMPORT_STEP_2_DESCRIPTION' => 'Format'                      , 
	'LBL_FILE_TYPE'                => 'Type de fichier'             , 
	'LBL_CHARACTER_ENCODING'       => 'Encodage des caractères'    , 
	'LBL_DELIMITER'                => 'Delimiteur'                  , 
	'LBL_HAS_HEADER'               => 'Contient une ligne d\'entetes', 
	'LBL_IMPORT_STEP_3'            => 'Etape 3'                     , 
	'LBL_IMPORT_STEP_3_DESCRIPTION' => 'Option de fusion'           , 
	'LBL_IMPORT_STEP_3_DESCRIPTION_DETAILED' => 'Activer cette option dans le cas de la mise à jour de fiches existantes dans le CRM', 
	'LBL_SPECIFY_MERGE_TYPE'       => 'Choisir comment les données mises à jour vont être traitées', 
	'LBL_SELECT_MERGE_FIELDS'      => 'Choisir les champs qui determinent la correspondance entre une ligne de votre fichier et la fiche dans le CRM', 
	'LBL_AVAILABLE_FIELDS'         => 'Champs disponibles'          , 
	'LBL_SELECTED_FIELDS'          => 'Champs sélectionnés'       , 
	'LBL_NEXT_BUTTON_LABEL'        => 'Suivant'                     , 
	'LBL_IMPORT_STEP_4'            => 'Etape 4'                     , 
	'LBL_IMPORT_STEP_4_DESCRIPTION' => 'Mapping des colonnes des champs du module', 
	'LBL_FILE_COLUMN_HEADER'       => 'Entêtes'                    , 
	'LBL_ROW_1'                    => 'Colonne 1'                   , 
	'LBL_CRM_FIELDS'               => 'Champs du CRM'               , 
	'LBL_DEFAULT_VALUE'            => 'Valeur par défaut'          , 
	'LBL_SAVE_AS_CUSTOM_MAPPING'   => 'Sauver ce mapping'           , 
	'LBL_IMPORT_BUTTON_LABEL'      => 'Import'                      , 
	'LBL_RESULT'                   => 'Resultats'                   , 
	'LBL_TOTAL_RECORDS_IMPORTED'   => 'Nombre total d\'enregistrements importés', 
	'LBL_NUMBER_OF_RECORDS_CREATED' => 'Nombre total d\'enregistrements créés', 
	'LBL_NUMBER_OF_RECORDS_UPDATED' => 'Nombre total d\'enregistrements fusionés', 
	'LBL_NUMBER_OF_RECORDS_SKIPPED' => 'Nombre total d\'enregistrements ignorés', 
	'LBL_NUMBER_OF_RECORDS_MERGED' => 'Nombre d\'enregistrements fusionnés', 
	'LBL_TOTAL_RECORDS_FAILED'     => 'Nombre total d\'enregistrements échoués', 
	'LBL_IMPORT_MORE'              => 'Importer plus d\'éléments' , 
	'LBL_VIEW_LAST_IMPORTED_RECORDS' => 'Derniers enregistrements imoportés', 
	'LBL_UNDO_LAST_IMPORT'         => 'Annuler le dernier import'   , 
	'LBL_FINISH_BUTTON_LABEL'      => 'Terminer'                    , 
	'LBL_UNDO_RESULT'              => 'Annler le résultat de l\'import', 
	'LBL_TOTAL_RECORDS'            => 'Nombre total d\'enregistrements', 
	'LBL_NUMBER_OF_RECORDS_DELETED' => 'Nombre d\'enregistrements supprimés', 
	'LBL_OK_BUTTON_LABEL'          => 'OK'                          , 
	'LBL_IMPORT_SCHEDULED'         => 'Import programmé'           , 
	'LBL_RUNNING'                  => 'En cours'                    , 
	'LBL_CANCEL_IMPORT'            => 'Annuler Import'              , 
	'LBL_ERROR'                    => 'Erreur'                      , 
	'LBL_CLEAR_DATA'               => 'Effacer les données'        , 
	'ERR_UNIMPORTED_RECORDS_EXIST' => 'Il existe des données non traités dans le processus d\'import, vous empéchant d\'importer des données pour ce module. <br>
										Purger les données non importées pour relancer un nouvel import', 
	'ERR_IMPORT_INTERRUPTED'       => 'L\'import courant a été interrompu. Essayez plus tard.', 
	'ERR_FAILED_TO_LOCK_MODULE'    => 'Impossible de vérouiller ce module pour l\'import. Essayez plus tard', 
	'LBL_SELECT_SAVED_MAPPING'     => 'Sélectionnez cartographie enregistrées'        , 
	'LBL_IMPORT_ERROR_LARGE_FILE'  => 'Erreur d\'importation de fichier grand'    , // TODO: Review
	'LBL_FILE_UPLOAD_FAILED'       => 'Échec de téléchargement de fichiers'          , // TODO: Review
	'LBL_IMPORT_CHANGE_UPLOAD_SIZE' => 'Importations Variation Télécharger Taille'   , // TODO: Review
	'LBL_IMPORT_DIRECTORY_NOT_WRITABLE' => 'Importation de répertoire n\'est pas accessible en écriture', // TODO: Review
	'LBL_IMPORT_FILE_COPY_FAILED'  => 'Copie du fichier d\'importation a échoué'     , // TODO: Review
	'LBL_INVALID_FILE'             => 'Fichier non valide'                , // TODO: Review
	'LBL_NO_ROWS_FOUND'            => 'Aucune ligne trouvée'               , // TODO: Review
	'LBL_SCHEDULED_IMPORT_DETAILS' => 'Votre importation a été prévue et débutera dans les 15 minutes. Vous recevrez un e-mail après l\'importation est terminée. <br> <br>
										S\'il vous plaît faire en sorte que le serveur sortant et votre adresse e-mail est configuré pour recevoir une notification email', // TODO: Review
	'LBL_DETAILS'                  => 'Details'                     , // TODO: Review
	'skipped'                      => 'Les enregistrements se sont arrêté'             , // TODO: Review
	'failed'                       => 'Les enregistrements ont échoué'              , // TODO: Review
        'Skip'=>'Skip',
        'Overwrite'=>'Écraser',
        'Merge'=>'Fusion',
);
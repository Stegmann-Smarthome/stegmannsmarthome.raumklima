<?php

// Klassendefinition
class luftfeuchtigkeit extends IPSModule {

    // Überschreibt die interne IPS_Create($id) Funktion
    public function Create() {
        // Diese Zeile nicht löschen.
        parent::Create();

        ############################## Anlegen / Erstellen eines Timers
        //$timer = $this->RegisterTimer("Update", 0, 'RK_TriggerAction(' . $this->InstanceID . ');');
        

        ############################## Erstellen von Variablen im Objektbaum
        $status             = $this->RegisterVariableBoolean("status_lueften", "Status", "", 1);
        $grenzwert          = $this->RegisterVariableInteger("grenzwert", "Grenzwert", "", 2);
        $meldeverzoegerung  = $this->RegisterVariableInteger("meldeverzoegerung", "Meldeverzögerung", "", 3);


        ############################## Erstellen von Eigenschaften, Konfigurationsformular (form.json) ##############################
        $this->RegisterPropertyInteger("ID-Luftfeuchtigkeit", 0);
        $this->RegisterPropertyInteger("ID-Webfront", 0);
        $this->RegisterPropertyBoolean("ID-Push", 0);
        $this->RegisterPropertyInteger("ID-Target", 0);


        ############################## Aktivieren von Standardaktion von Variablen (Objektbaum) ##############################
        $this->EnableAction("grenzwert");
        $this->EnableAction("meldeverzoegerung");


        ############################## Erstellen von neuen Variablenprofilen ##############################
        // Erstellung eines Variablenprofils für den Status
        if (!IPS_VariableProfileExists("SS.Klima.Status")) {
            IPS_CreateVariableProfile("SS.Klima.Status", 0); // 0 steht für Boolean
            IPS_SetVariableProfileAssociation("SS.Klima.Status", 0, "OK", "", 0x00FF00);
            IPS_SetVariableProfileAssociation("SS.Klima.Status", 1, "Lüften!", "", 0xFF0000);
        }

        // Erstellung eines Variablenprofils für den Grenzwert
        if (!IPS_VariableProfileExists("SS.Grenzwert")) {
            IPS_CreateVariableProfile("SS.Grenzwert", 1); // 2 steht für Integer
            IPS_SetVariableProfileText("SS.Grenzwert", "", " %");
            IPS_SetVariableProfileValues("SS.Grenzwert", 0, 100, 1);
        }
        
        // Erstellung eines Variablenprofils für die Meldeverzögerung
        if (!IPS_VariableProfileExists("SS.Meldeverzoegerung")) {
            IPS_CreateVariableProfile("SS.Meldeverzoegerung", 1); // 2 steht für Integer
            IPS_SetVariableProfileText("SS.Meldeverzoegerung", "", " Minuten");
            IPS_SetVariableProfileValues("SS.Meldeverzoegerung", 0, 30, 1); // Wertebereich von 0 bis 30 Minuten
        }


        ############################## Zuweisen von Icons zu Profilen ##############################
        IPS_SetVariableProfileIcon("SS.Klima.Status", "Information");
        IPS_SetVariableProfileIcon("SS.Grenzwert", "Intensity"); 
        IPS_SetVariableProfileIcon("SS.Meldeverzoegerung", "Distance");
    

        ############################## Zuweisen Profilen zu Variablen im Objektbaum ##############################
        IPS_SetVariableCustomProfile($status, "SS.Klima.Status");
        IPS_SetVariableCustomProfile($grenzwert, "SS.Grenzwert");
        IPS_SetVariableCustomProfile($meldeverzoegerung, "SS.Meldeverzoegerung");
    }


    // Überschreibt die interne IPS_ApplyChanges($id) Funktion
    public function ApplyChanges() {
        // Diese Zeile nicht löschen
        parent::ApplyChanges();

        // Überprüfen, ob ein Link bereits existiert, wenn noch kein Link existiert und bereits eine Ziel-ID im Instanzkonfigurator ausgewählt wurde, wird ein Objektlink erstellt
        $linkID = @$this->GetIDForIdent("LinkLuftfeuchtigkeit");
        if ($linkID == false && IPS_VariableExists($this->ReadPropertyInteger("ID-Luftfeuchtigkeit"))) {
            // Erstellt einen Link, wenn eine Variable / ID aus dem Objektbaum ausgewählt wurde und kein Link existiert
            $ist_luftfeuchtigkeit = IPS_CreateLink();                                                       // Create link
            IPS_SetName($ist_luftfeuchtigkeit, "Luftfeuchtigkeit");                                         // Name the link
            IPS_SetParent($ist_luftfeuchtigkeit, $this->InstanceID);                                        // Set a parent
            IPS_SetLinkTargetID($ist_luftfeuchtigkeit, $this->ReadPropertyInteger("ID-Luftfeuchtigkeit"));  // Attach the link
            IPS_SetIdent($ist_luftfeuchtigkeit, "LinkLuftfeuchtigkeit");                                    // Set an identifier for the link
        }
     

        // Aktualisiert den Objektlink, wenn sich die ausgewählte Ziel-ID geändert hat
        if ($linkID == true && IPS_VariableExists($this->ReadPropertyInteger("ID-Luftfeuchtigkeit"))) {
            IPS_SetLinkTargetID($linkID, $this->ReadPropertyInteger("ID-Luftfeuchtigkeit"));
        }


        // Setzt das Profil für die Variable von der der Link verlinkt
        $targetID = $this->ReadPropertyInteger("ID-Luftfeuchtigkeit");
        if ($targetID > 0) {
            IPS_SetVariableCustomProfile($targetID, "~Humidity.F");
        }


        // Hier werden Änderungen auf die erstellte(n) Formular-Variable(n) mithilfe von "RegisterMessage" registriert
        $this->RegisterMessage($this->ReadPropertyInteger("ID-Luftfeuchtigkeit"), VM_UPDATE);
    }


    public function MessageSink($TimeStamp, $SenderID, $Message, $Data) {
        $this->luftfeuchtigkeit();

     }

    /**
     * Die folgenden Funktionen stehen automatisch zur Verfügung, wenn das Modul über die "Module Control" eingefügt wurden.
     * Die Funktionen werden, mit dem selbst eingerichteten Prefix, in PHP und JSON-RPC wie folgt zur Verfügung gestellt:
     * 
     * RK_TriggerAction($id);
     * 
     */

    // Je nach veränderter Variable im Frontend, wird die dazugehörige Funktion aufgerufen und ausgeführt
    public function RequestAction($Ident, $Value) {
        switch ($Ident) {
            case "grenzwert":
                $this->SetValue($Ident, $Value);
                $this->luftfeuchtigkeit();
                $this->feuchtigkeitsmeldung();
                break;
            case "meldeverzoegerung":
                $this->SetValue($Ident, $Value);
                $this->feuchtigkeitsmeldung();
                break;
            default:
                throw new Exception("Invalid Ident"); 
        }
    }


    public function luftfeuchtigkeit() {

        // Wenn der Grenzwert oder die Luftfeuchtigkeit aktualisiert wird, eine Prüfung durchführen
        $ist_luftfeuchtigkeit       = GetValue($this->ReadPropertyInteger("ID-Luftfeuchtigkeit"));
        $grenzwert                  = GetValue($this->GetIDForIdent("grenzwert"));

        if ($ist_luftfeuchtigkeit > $grenzwert) {
            // Status setzen + Feuchtigkeitsmeldung senden
            SetValue($this->GetIDForIdent("status_lueften"), true);
        } else {
            // Status zurücksetzen
            SetValue($this->GetIDForIdent("status_lueften"), false);
            $this->feuchtigkeitsmeldung();
        }
        
    }

    
    public function feuchtigkeitsmeldung() {
    // Senden einer Push-Nachricht, wenn der Grenzwert über die Zeit der Meldeverzögerung überschritten wird
    $ident  = $this->GetIDForIdent("status_lueften");
    $status = $this->GetValue("status_lueften");
        
    $meldeverzoegerung = GetValue($this->GetIDForIdent("meldeverzoegerung"));
                
    $content    = IPS_GetVariable($ident);
    $result     = time() - $content['VariableChanged'];
    $minuten    = $result / 60;
    $minuten    = $minuten + 1/60;
                
    $pushID     = $this->ReadPropertyInteger("ID-Webfront");
    $pushstatus = $this->ReadPropertyBoolean("ID-Push");
    $Bufferdata = $this->GetBuffer("PushNachricht");
    $targetID   = $this->ReadPropertyInteger("ID-Target");
        

    if ($status == true) {
        if ($minuten > $meldeverzoegerung && $pushstatus == true && $Bufferdata != "Sent") {
            VISU_PostNotificationEx($pushID, "Luftfeuchtigkeit!", "Die Luftfeuchtigkeit ist zu hoch!", "Alert", "alarm", 0);
            $this->SetBuffer("PushNachricht", "Sent");
        }
    }
    else {
        $this->SetBuffer("PushNachricht", "Reset");
    }
    }
}
?>
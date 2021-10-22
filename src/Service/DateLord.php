<?php

namespace App\Service;

class DateLord
{



    public function langues($choix)
    {

        $langues = [

            "de" => ["Januar","Februar","März","April","Mai","Juni","Juli","August","September","Oktober","November","Dezember"],
            "en" => ["January","February","March","April","May","June","July","August","September","October","November","December"],
            "es" => ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],
            "fr" => ["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"],
            "it" => ["Gennaio","Febbraio","Marzo","Aprile","Maggio","Giugno","Luglio","Agosto","Settembre","Ottobre","Novembre","Dicembre"],
            "pt" => ["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"],
            "pl" => ["Styczeń","Luty","Marzec","Kwiecień","Maj","Czerwiec","Lipiec","Sierpień","Wrzesień","Październik","Listopad","Grudzień"],
            "tr" => ["ocak","şubat","mart","nisan","mayıs","haziran","temmuz","ağustos","eylül","ekim","kasım","aralık"]

        ];


        foreach($langues as $pays => $langue)
        {
            if($pays == $choix)
            {
                return $langue;
            }

        }
    

    }

    public function heures($langue)
    {
        $heures = [
            "de" => ["stunde","stunde"],
            "en" => ["hour", "hours"],
            "es" => ["hora", "hora"],
            "fr" => ["heure","heures"],
            "it" => ["ora","ora"],
            "pt" => ["hora", "hora"],
            "pl" => ["godzina","godzina"],
            "tr" => ["saat","saat"]
        ];

        foreach($heures as $pays => $heure)
        {
            if($pays == $langue)
            {
                return $heure;
            }

        }
    }

    public function languesChoice($choix)
    {

        $langues = [


            "de" => [
                "mois" => ["Januar","Februar","März","April","Mai","Juni","Juli","August","September","Oktober","November","Dezember"],
                "heures" => ["stunde","stunde"],
                "midi" => "mittag",
                "minuit" => "mitternacht",
                "at" => "um"
            ],


            "en" => [
                "mois" => ["January","February","March","April","May","June","July","August","September","October","November","December"],
                "heures" => ["hour", "hours"],
                "midi" => "midday",
                "minuit" => "midnight",
                "at" => "at"
            ],

            "es" => [
                "mois" => ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],
                "heures" => ["hora", "hora"],
                "midi" => "mediodía",
                "minuit" => "doce de la noche",
                "at" => "a"
            ],

            "fr" => [
                "mois" => ["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"],
                "heures" => ["heure", "heures"],
                "midi" => "midi",
                "minuit" => "minuit",
                "at" => "à"
            ],


            "it" => [
                "mois" => ["Gennaio","Febbraio","Marzo","Aprile","Maggio","Giugno","Luglio","Agosto","Settembre","Ottobre","Novembre","Dicembre"],
                "heures" => ["ora","ora"],
                "midi" => "mezzogiorno",
                "minuit" => "mezzanotte",
                "at" => "alle"
            ],


            "pl" => [
                "mois" => ["Styczeń","Luty","Marzec","Kwiecień","Maj","Czerwiec","Lipiec","Sierpień","Wrzesień","Październik","Listopad","Grudzień"],
                "heures" => ["godzina","godzina"],
                "midi" => "południe",
                "minuit" => "północ",
                "at" => "o"
            ],


            "pt" => [
                "mois" => ["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"],
                "heures" => ["hora", "hora"],
                "midi" => "meio dia",
                "minuit" => "meia-noite",
                "at" => "às"
            ],


            "tr" => [
                "mois" => ["ocak","şubat","mart","nisan","mayıs","haziran","temmuz","ağustos","eylül","ekim","kasım","aralık"],
                "heures" => ["saat","saat"],
                "midi" => "öğlen",
                "minuit" => "gece yarısı",
                "at" => "de"
            ],




        ];


        foreach($langues as $pays => $langue)
        {
            if($pays == $choix)
            {
                return $langue;
            }

        }
    

    }


    public function minuit($langue)
    {
        $minuit = [
            "de" => "mitternacht",
            "en" => "midnight",
            "es" => "doce de la noche",
            "fr" => "minuit",
            "it" => "mezzanotte",
            "pt" => "meia-noite",
            "pl" => "północ",
            "tr" => "gece yarısı"
        ];

        foreach($minuit as $pays => $value)
        {
            if($pays == $langue)
            {
                return $value;
            }

        }
    }


    public function midi($langue)
    {
        $midi = [
            "de" => "mittag",
            "en" => "midday",
            "es" => "mediodía",
            "fr" => "midi",
            "it" => "mezzogiorno",
            "pt" => "meio dia",
            "pl" => "południe",
            "tr" => "öğlen"
        ];

        foreach($midi as $pays => $value)
        {
            if($pays == $langue)
            {
                return $value;
            }

        }
    }

    public function at($langue)
    {
        $at = [
            "de" => "um",
            "en" => "at",
            "es" => "a",
            "fr" => "à",
            "it" => "alle",
            "pt" => "às",
            "pl" => "o",
            "tr" => "de"
        ];

        foreach($at as $pays => $value)
        {
            if($pays == $langue)
            {
                return $value;
            }

        }
    }


    public function moisFr6($produitObject, $langue, $time = null)
    {

        $dateObject = $produitObject->getDateAt();

        $moisNum = $dateObject->format("m");

        $moisArray = $this->langues($langue);

        foreach($moisArray as $key => $value)
        {

            if($key + 1 == $moisNum)
            {
                $moisFr = $value;
            }
        }

        $heure = "";

        $hours = $this->heures($langue);
        
        if($time == "H")
        {
            if($dateObject->format("H") == 0 )
            {
                $heure = " à " . $this->minuit($langue);
            }
            elseif($dateObject->format("H") == 1 )
            {
                $heure = " à 1 " . $hours[0];
            }
            else
            {
                $heure = " à " . $dateObject->format("H") . " " . $hours[1];
            }
            
        }
        elseif($time == "Hi")
        {
            $heure = " à " . $dateObject->format("H:i");
        }
        elseif($time == "His")
        {
            $heure = " à " . $dateObject->format("H:i:s");
        }
        

      if($dateObject->format("d") == 1)
      {
          $jour = "1er";
      }
      else 
      {
          $jour = $dateObject->format("d");
      }

        $produitObject->newDate = $jour . " " . $moisFr . " " . $dateObject->format("Y") . $heure;
        return $produitObject;


        
    }


    public function mois($produitsArray, $langue, $time = null)
    {
        
        //dd(is_array($produitsArray));


        if(is_array($produitsArray))
        {

            foreach($produitsArray as $produitObject)
            {
                $this->moisFr6($produitObject, $langue, $time);
            }

        }
        else
        {
            $this->moisFr6($produitsArray, $langue, $time);
        }



        return $produitsArray;

    }



}
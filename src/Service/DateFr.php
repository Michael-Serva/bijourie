<?php

namespace App\Service;

class DateFr
{


    public function moisFr($mois)
    {
    
        switch($mois)
        {

            case 1 :
                $moisFr = "janvier";
            break;

            case 2 :
                $moisFr = "février";
            break;

            case 3 :
                $moisFr = "mars";
            break;

            case 4 :
                $moisFr = "avril";
            break;

            case 5 :
                $moisFr = "mai";
            break;

            case 6 :
                $moisFr = "juin";
            break;

            case 7 :
                $moisFr = "juillet";
            break;

            case 8 :
                $moisFr = "août";
            break;

            case 9 :
                $moisFr = "septembre";
            break;

            case 10 :
                $moisFr = "octobre";
            break;

            case 11 :
                $moisFr = "novembre";
            break;

            case 12 :
                $moisFr = "décembre";
            break;

            default;




        }


        return $moisFr;
    
    
    }


    public function moisFr2($mois)
    {
        $moisArray = [
            "janvier",
            "février",
            "mars",
            "avril",
            "mai",
            "juin",
            "juillet",
            "août",
            "septembre",
            "octobre",
            "novembre",
            "décembre" 
        ];

        foreach($moisArray as $key => $value)
        {

            if($key + 1 == $mois)
            {
                $moisFr = $value;
            }
        }

        return $moisFr;
    }



    public function moisFr3($dateObject)
    {

        $moisNum = $dateObject->format("m");

        $moisArray = [
            "janvier",
            "février",
            "mars",
            "avril",
            "mai",
            "juin",
            "juillet",
            "août",
            "septembre",
            "octobre",
            "novembre",
            "décembre" 
        ];

        foreach($moisArray as $key => $value)
        {

            if($key + 1 == $moisNum)
            {
                $moisFr = $value;
            }
        }


        $newDate = $dateObject->format("d") . " " . $moisFr . " " . $dateObject->format("Y");


        return $newDate;


        
    }


    public function moisFr4($dateObject, $time = null)
    {

        $moisNum = $dateObject->format("m");

        $moisArray = [
            "janvier",
            "février",
            "mars",
            "avril",
            "mai",
            "juin",
            "juillet",
            "août",
            "septembre",
            "octobre",
            "novembre",
            "décembre" 
        ];

        foreach($moisArray as $key => $value)
        {

            if($key + 1 == $moisNum)
            {
                $moisFr = $value;
            }
        }

        $heure = "";

        if($time)
        {
            $heure = " à " . $dateObject->format("H:i:s");
        }

        $newDate = $dateObject->format("d") . " " . $moisFr . " " . $dateObject->format("Y") . $heure;


        return $newDate;


        
    }


    public function moisFr6($produitObject, $time = null)
    {

        $dateObject = $produitObject->getDateAt();

        $moisNum = $dateObject->format("m");

        $moisArray = [
            "janvier",
            "février",
            "mars",
            "avril",
            "mai",
            "juin",
            "juillet",
            "août",
            "septembre",
            "octobre",
            "novembre",
            "décembre" 
        ];

        foreach($moisArray as $key => $value)
        {

            if($key + 1 == $moisNum)
            {
                $moisFr = $value;
            }
        }

        $heure = "";

        if($time)
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





    public function moisFr5($produitsArray, $time = null)
    {



        //dd($produitsArray);
        
        foreach($produitsArray as $produitObject)
        {
                $this->moisFr6($produitObject, $time);
        }


        return $produitsArray;


        
    }


    public function langue()
    {

        $langues = [

            "de" => ["Januar","Februar","März","April","Mai","Juni","Juli","August","September","Oktober","November","Dezember"],
            "en" => ["January","February","March","April","May","June","July","August","September","October","November","December"],
            "es" => ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],
            "fr" => ["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"],
            "it" => ["Gennaio","Febbraio","Marzo","Aprile","Maggio","Giugno","Luglio","Agosto","Settembre","Ottobre","Novembre","Dicembre"],
            "pt" => ["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"],
            "pl" => ["Styczeń","Luty","Marzec","Kwiecień","Maj","Czerwiec","Lipiec","Sierpień","Wrzesień","Październik","Listopad","Grudzień"]

        ];
        




        /*
            $Allemand = ["Januar","Februar","März","April","Mai","Juni","Juli","August","September","Oktober","November","Dezember"];
            $Alsacien = ["Janner","Horni","März","April","Mai","Jüni","Jüli","Äugscht","Septamber","Oktower","Novamber","Dezamber"];
            $Anglais = ["January","February","March","April","May","June","July","August","September","October","November","December"];
            $basque	= ["Urtarril","Otsail","Martxoa","Apiril","Maiatz","Ekain","Uztail","Abuztu","Irail","Urri","Azaro","Abendu"];
            $Breton= ["Genver","C'hwevrer","Meurzh","Ebrel","Mae","Mezheven","Gouere","Eost","Gwengolo","Here","Du","Kerzu"];
            $Catalan= ["Gener","Febrer","Març","Abril","Maig","Juny","Juliol","Agost","Setembre","Octubre","Novembre","Desembre"];
            $Corse= ["Ghjennaghju","Ferraghju","Marzu","Aprile","Maghju","Ghjugnu","Lugliu","Aostu","Sittembre","Uttobre","Nuvembre","Dicembre"];
            $Danois	= ["Januar","Februar","Marts","April","Maj","Juni","Juli","August","September","Oktober","November","December"];
            $Espagnol= ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
            $Estonien= ["Jaanuar","Veebruar","Märts","Aprill","Mai","Juuni","Juuli","August","September","Oktoober","November","Detsember"];
            $Finnois= ["Tammikuun","Helmikuun","Maaliskuun","Huhtikuun","Toukokuun","Kesäkuun","Heinäkuun","Elokuun","Syyskuun","Lokakuun","Marraskuun","Joulukuun"];
            $Français= ["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"];
            $GaéliqueEcossais= ["Fhaoilteach","Ghearran","Mhàrt","Ghiblean","Chèitean","Òg-mhìos","Iuchar","Lùnasdal","t-Sultuine","Dàmhair","t-Samhainn","Dùbhlachd"];
            $GaéliqueIrlandais= ["Eanáir","Feabhra","Márta","Aibreán","Bealtaine","Meitheamh","Iúil","Lúnasa","Meán","Fómhair","Deireadh","Fómhair","Samhain","Nollaig"];
            $Gallois= ["Ionawr","Chwefror","Mawrth","Ebrill","Mai","Mehefin","Gorffennaf","Awst","Medi","Hydref","Tachwedd","Rhagfyr"];
            $Grec = ["Ιανουάριος","Φεβρουάριος","Μάρτιος","Απρίλιος","Μάιος","Ιούνιος","Ιούλιος","Αύγουστος","Σεπτέμβριος","Οκτώβριος","Νοέμβριος","Δεκέμβριος"];
            $Islandais	= ["Janúar","Febrúar","Mars","Apríl","Maí","Júní","Júlí","Ágúst","September","Október","Nóvember","Desember"];
            $Italien= ["Gennaio","Febbraio","Marzo","Aprile","Maggio","Giugno","Luglio","Agosto","Settembre","Ottobre","Novembre","Dicembre"];
            $Latin	= ["Januarius","Februarius","Martius","Aprilis","Maius","Junius","Julius","Augustus","September","October","Novembris","December"];
            $Letton	= ["Janvāris","Februāris","Marts","Aprīlis","Maijs","Jūnijs","Jūlijs","Augusts","Septembris","Oktobris","Novembris","Decembris"];
            $Néerlandais= ["Januari","Februari","Maart","April","Mei","Juni","Juli","Augustus","September","Oktober","November","December"];
            $Normand= ["Jaunvyi","Févryi","Mâr","Avri","Mouai","Juin","Juilet","Âot","S'tembe","Octobe","Novembe","Décembe"];
            $Occitant= ["Janvier","Febrier","Març","Abriu","Mai","Junh","Julhet","Aost","Septembre","Octòbre","Novembre","cembre"];
            $Poitevin= ["Jhanvràe","Fouvràe","Mar","Avrell","Mae","Jhén","Jhullét","Àut","Sébtenbre","Octoubre","Nouvenbre","Décenbre"];
            $Portugais= ["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"];
            $pologne = ["Styczeń","Luty","Marzec","Kwiecień","Maj","Czerwiec","Lipiec","Sierpień","Wrzesień","Październik","Listopad","Grudzień"];
            $Provençal= ["Janvié","Febrié","Mars","Abriéu","Mai","Jun","Juliet","Avoust","Sètembre","Óutobre","Nouvèmbre","Desèmbre"];
            $Roumain= ["Ianuarie","Februarie","Martie","Aprilie","Mai","Iunie","Iulie","Aot","Septembrie","Octombrie","Noiembrie","Decembrie"];
            $Russe= ["январь","февраль","март","апрель","май","июнь","июль","август","сентябрь","октябрь","ноябрь","декабрь"];
            $Suédois= ["Januari","Februari","Mars","April","Maj","Juni","Juli","Augusti","September","Oktober","November","December"];
            $Swahili= ["Januari","Februari","Machi","Aprili","Mei","Juni","Julai","Agosti","Septemba","Oktoba","Novemba","Desemba"];
            $Wallon	= ["Djanvî","Fèvrî","Mås'","Avrî","Maey","Djun","Djulèt'","Awous","Sètimbe","Octôbe","Novimbe","Décimbe"];
        */

    }


}
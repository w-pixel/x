<?php

namespace App\Traits;

trait Arabic
{
    private $alfmd = ["ﺁ", "ﺁ", "ﺂ", "ﺂ"];
    private $alfhz = ["ﺃ", "ﺃ", "ﺄ", "ﺄ"];
    private $wowhz = ["ﺅ", "ﺅ", "ﺆ", "ﺆ"];
    private $alfxr = ["ﺇ", "ﺇ", "ﺈ", "ﺈ"];
    private $hamzk = ["ﺉ", "ﺋ", "ﺌ", "ﺊ"];
    private $alfff = ["ﺍ", "ﺍ", "ﺎ", "ﺎ"];
    private $baaaa = ["ﺏ", "ﺑ", "ﺒ", "ﺐ"];
    private $tamrb = ["ﺓ", "ﺓ", "ﺔ", "ﺔ"];
    private $taaaa = ["ﺕ", "ﺗ", "ﺘ", "ﺖ"];
    private $thaaa = ["ﺙ", "ﺛ", "ﺜ", "ﺚ"];
    private $geeem = ["ﺝ", "ﺟ", "ﺠ", "ﺞ"];
    private $haaaa = ["ﺡ", "ﺣ", "ﺤ", "ﺢ"];
    private $khaaa = ["ﺥ", "ﺧ", "ﺨ", "ﺦ"];
    private $daaal = ["ﺩ", "ﺩ", "ﺪ", "ﺪ"];
    private $thaal = ["ﺫ", "ﺫ", "ﺬ", "ﺬ"];
    private $raaaa = ["ﺭ", "ﺭ", "ﺮ", "ﺮ"];
    private $zaaai = ["ﺯ", "ﺯ", "ﺰ", "ﺰ"];
    private $seeen = ["ﺱ", "ﺳ", "ﺴ", "ﺲ"];
    private $sheen = ["ﺵ", "ﺷ", "ﺸ", "ﺶ"];
    private $saaad = ["ﺹ", "ﺻ", "ﺼ", "ﺺ"];
    private $daaad = ["ﺽ", "ﺿ", "ﻀ", "ﺾ"];
    private $taaah = ["ﻁ", "ﻃ", "ﻄ", "ﻂ"];
    private $daaah = ["ﻅ", "ﻇ", "ﻈ", "ﻆ"];
    private $aayen = ["ﻉ", "ﻋ", "ﻌ", "ﻊ"];
    private $gayen = ["ﻍ", "ﻏ", "ﻐ", "ﻎ"];
    private $faaaa = ["ﻑ", "ﻓ", "ﻔ", "ﻒ"];
    private $qaaaf = ["ﻕ", "ﻗ", "ﻘ", "ﻖ"];
    private $kaaaf = ["ﻙ", "ﻛ", "ﻜ", "ﻚ"];
    private $laaam = ["ﻝ", "ﻟ", "ﻠ", "ﻞ"];
    private $meeem = ["ﻡ", "ﻣ", "ﻤ", "ﻢ"];
    private $nooon = ["ﻥ", "ﻧ", "ﻨ", "ﻦ"];
    private $hhhhh = ["ﻩ", "ﻫ", "ﻬ", "ﻪ"];
    private $wowww = ["ﻭ", "ﻭ", "ﻮ", "ﻮ"];
    private $yaamd = ["ﻯ", "ﻯ", "ﻰ", "ﻰ"];
    private $yaaaa = ["ﻱ", "ﻳ", "ﻴ", "ﻲ"];
    private $laamd = ["ﻵ", "ﻵ", "ﻶ", "ﻶ"];
    private $laahz = ["ﻷ", "ﻷ", "ﻸ", "ﻸ"];
    private $laaxr = ["ﻹ", "ﻹ", "ﻺ", "ﻺ"];
    private $laaaa = ["ﻻ", "ﻻ", "ﻼ", "ﻼ"];

    // Other properties
    public $chaine_traitee = "";
    private $unicode = "ﺁﺁﺂﺂﺃﺃﺄﺄﺅﺅﺆﺆﺇﺇﺈﺈﺉﺋﺌﺊﺍﺍﺎﺎﺏﺑﺒﺐﺓﺓﺔﺔﺕﺗﺘﺖﺙﺛﺜﺚﺝﺟﺠﺞﺡﺣﺤﺢﺥﺧﺨﺦﺩﺩﺪﺪﺫﺫﺬﺬﺭﺭﺮﺮﺯﺯﺰﺰﺱﺳﺴﺲﺵﺷﺸﺶﺹﺻﺼﺺﺽﺿﻀﺾﻁﻃﻄﻂﻅﻇﻈﻆﻉﻋﻌﻊﻍﻏﻐﻎﻑﻓﻔﻒﻕﻗﻘﻖﻙﻛﻜﻚﻝﻟﻠﻞﻡﻣﻤﻢﻥﻧﻨﻦﻩﻫﻬﻪﻭﻭﻮﻮﻯﻯﻰﻰﻱﻳﻴﻲﻵﻵﻶﻶﻷﻷﻸﻸﻹﻹﻺﻺﻻﻻﻼﻼ";
    private $left = "ـئظشسيبلتنمكطضصثقفغعهخحج";
    private $right = "ـئؤرلالآىآةوزظشسيبللأاأتنمكطضصثقفغعهخحج";
    private $arabic = "ًٌٍَُِّْْئءؤرلاىةوزظشسيبلاتنمكطضصثقفغعهخحج";
    private $harakat = "ًٌٍَُِّْْ";
    private $sym = "ًٌٍَُِّـ.،؟ @#$%^&*-+|\/=~(){}ْ,";

    private $g;


    function ProcessInput($chaine)
    {
        $this->chaine_traitee = "";
    $x = preg_split('//u', $chaine, -1, PREG_SPLIT_NO_EMPTY);
    $len = count($x);

    for ($this->g = 0; $this->g < $len; $this->g++) {
        $b = $a = 1;

        // Ignore the harakat
        while ($this->g - $b >= 0 && strpos($this->harakat, $x[$this->g - $b]) !== false) {
            $b++;
        }

        while ($this->g + $a < $len && strpos($this->harakat, $x[$this->g + $a]) !== false) {
            $a++;
        }

        if ($this->g == 0) {
            if (strpos($this->right, $x[$this->g + $a]) !== false) {
                $pos = 1;
            } else {
                $pos = 0;
            }
        } else if ($this->g == ($len - 1)) {
            if (strpos($this->left, $x[$len - $b - 1]) !== false) {
                $pos = 3;
            } else {
                $pos = 0;
            }
        } else {
            if (strpos($this->left, $x[($this->g - $b)]) !== false && strpos($this->right, $x[($this->g + $a)]) !== false) {
                $pos = 2;
            } else if (strpos($this->left, $x[($this->g - $b)]) === false && strpos($this->right, $x[($this->g + $a)]) === false) {
                $pos = 0;
            } else if (strpos($this->left, $x[($this->g - $b)]) === false && strpos($this->right, $x[($this->g + $a)]) !== false) {
                $pos = 1;
            } else if (strpos($this->left, $x[($this->g - $b)]) !== false && strpos($this->right, $x[($this->g + $a)]) === false) {
                $pos = 3;
            }
        }

            if ($x[$this->g] == "\n") {
                $this->addChar("\n");
            } else if ($x[$this->g] == "\r") {
                // Skip carriage return
            } else if ($x[$this->g] == "{") {
                $this->addChar("}");
            } else if ($x[$this->g] == "}") {
                $this->addChar("{");
            } else if ($x[$this->g] == "(") {
                $this->addChar(")");
            } else if ($x[$this->g] == ")") {
                $this->addChar("(");
            } else if ($x[$this->g] == "ء") {
                $this->addChar("ﺀ");
            } else if ($x[$this->g] == "آ") {
                $this->addChar($this->alfmd[$pos]);
            } else if ($x[$this->g] == "أ") {
                $this->addChar($this->alfhz[$pos]);
            } else if ($x[$this->g] == "ؤ") {
                $this->addChar($this->wowhz[$pos]);
            } else if ($x[$this->g] == "إ") {
                $this->addChar($this->alfxr[$pos]);
            } else if ($x[$this->g] == "ئ") {
                $this->addChar($this->hamzk[$pos]);
            } else if ($x[$this->g] == "ا") {
                $this->addChar($this->alfff[$pos]);
            } else if ($x[$this->g] == "ب") {
                $this->addChar($this->baaaa[$pos]);
            } else if ($x[$this->g] == "ة") {
                $this->addChar($this->tamrb[$pos]);
            } else if ($x[$this->g] == "ت") {
                $this->addChar($this->taaaa[$pos]);
            } else if ($x[$this->g] == "ث") {
                $this->addChar($this->thaaa[$pos]);
            } else if ($x[$this->g] == "ج") {
                $this->addChar($this->geeem[$pos]);
            } else if ($x[$this->g] == "ح") {
                $this->addChar($this->haaaa[$pos]);
            } else if ($x[$this->g] == "خ") {
                $this->addChar($this->khaaa[$pos]);
            } else if ($x[$this->g] == "د") {
                $this->addChar($this->daaal[$pos]);
            } else if ($x[$this->g] == "ذ") {
                $this->addChar($this->thaal[$pos]);
            } else if ($x[$this->g] == "ر") {
                $this->addChar($this->raaaa[$pos]);
            } else if ($x[$this->g] == "ز") {
                $this->addChar($this->zaaai[$pos]);
            } else if ($x[$this->g] == "س") {
                $this->addChar($this->seeen[$pos]);
            } else if ($x[$this->g] == "ش") {
                $this->addChar($this->sheen[$pos]);
            } else if ($x[$this->g] == "ص") {
                $this->addChar($this->saaad[$pos]);
            } else if ($x[$this->g] == "ض") {
                $this->addChar($this->daaad[$pos]);
            } else if ($x[$this->g] == "ط") {
                $this->addChar($this->taaah[$pos]);
            } else if ($x[$this->g] == "ظ") {
                $this->addChar($this->daaah[$pos]);
            } else if ($x[$this->g] == "ع") {
                $this->addChar($this->aayen[$pos]);
            } else if ($x[$this->g] == "غ") {
                $this->addChar($this->gayen[$pos]);
            } else if ($x[$this->g] == "ف") {
                $this->addChar($this->faaaa[$pos]);
            } else if ($x[$this->g] == "ق") {
                $this->addChar($this->qaaaf[$pos]);
            } else if ($x[$this->g] == "ك") {
                $this->addChar($this->kaaaf[$pos]);
            } else if ($x[$this->g] == "ل") {
                $this->g++;
                if ($x[$this->g] == "ا") {
                    $this->addChar($this->laaaa[$pos]);
                } else if ($x[$this->g] == "أ") {
                    $this->addChar($this->laahz[$pos]);
                } else if ($x[$this->g] == "إ") {
                    $this->addChar($this->laaxr[$pos]);
                } else if ($x[$this->g] == "آ") {
                    $this->addChar($this->laamd[$pos]);
                } else {
                    $this->g--;
                    $this->addChar($this->laaam[$pos]);
                }
            } else if ($x[$this->g] == "م") {
                $this->addChar($this->meeem[$pos]);
            } else if ($x[$this->g] == "ن") {
                $this->addChar($this->nooon[$pos]);
            } else if ($x[$this->g] == "ه") {
                $this->addChar($this->hhhhh[$pos]);
            } else if ($x[$this->g] == "و") {
                $this->addChar($this->wowww[$pos]);
            } else if ($x[$this->g] == "ى") {
                $this->addChar($this->yaamd[$pos]);
            } else if ($x[$this->g] == "ي") {
                $this->addChar($this->yaaaa[$pos]);
            } else if ($x[$this->g] == "لآ") {
                $this->addChar($this->laamd[$pos]);
            } else if ($x[$this->g] == "لأ") {
                $this->addChar($this->laahz[$pos]);
            } else if ($x[$this->g] == "لإ") {
                $this->addChar($this->laaxr[$pos]);
            } else if ($x[$this->g] == "لا") {
                $this->addChar($this->laaaa[$pos]);
            } else if ($x[$this->g] == " ") {
                $this->addChar(" ");
            } else if (strpos($this->sym, $x[$this->g]) !== false) {
                $this->addChar($x[$this->g]);
            } else if (strpos($this->unicode, $x[$this->g]) !== false) {
                $this->addChar($x[$this->g]);
            } else {
                $this->addChar($x[$this->g], $this->g);
            }
        }
        return $this->chaine_traitee;
    }


    public function correction_retour($chaine)
    {
        $tab = explode("\n", $chaine);
        $tab = array_reverse($tab);
        $chaine = implode("\n", $tab);
        return $chaine;
    }

    public function Traitement($input)
    {
        $chaine = $this->ProcessInput($input);
        $chaine = $this->correction_retour($chaine);
        $chaine = $this->correction_Latin($chaine);
        return $chaine;
    }

    public function correction_Latin($chaine)
    {
        $x = str_split($chaine);
        $x = array_reverse($x);
        $i_debut = -1;
        $i_fin = count($x);

        for ($i = 0; $i < count($x); $i++) {
            if (strpos($this->arabic, $x[$i]) === false && strpos($this->unicode, $x[$i]) === false && isset($x[$i])) {
                if ($i_debut == -1)
                    $i_debut = $i;

                if ($i == count($x) - 1) {
                    $i_fin = $i;
                    $lon = $i_fin - $i_debut;

                    if ($lon >= 1) {
                        $tab_a = array_slice($x, 0, $i_debut);
                        $tab_b = array_slice($x, $i_debut, $i_fin - $i_debut + 1);
                        $tab_b = array_reverse($tab_b);
                        $tab_c = array_slice($x, $i_fin + 1, count($x));
                        $x = array_merge($tab_a, $tab_b, $tab_c);
                        $i_debut = -1;
                        $i_fin = count($x) - 1;
                    }
                }
            } else {
                if ($i_debut != -1) {
                    $i_fin = $i - 1;
                    $lon = $i_fin - $i_debut;

                    if ($lon == 0) {
                    }

                    if ($lon >= 1) {
                        if ($i_debut == 0) {
                            $tab_a = array_slice($x, 0, $i_fin + 1);
                            $tab_a = array_reverse($tab_a);
                            $tab_b = array_slice($x, $i_fin + 1, count($x));
                            $x = array_merge($tab_a, $tab_b);
                        } else {
                            $tab_a = array_slice($x, 0, $i_debut);
                            $tab_b = array_slice($x, $i_debut, $i_fin - $i_debut + 1);
                            $tab_b = array_reverse($tab_b);
                            $tab_c = array_slice($x, $i_fin + 1, count($x));
                            $x = array_merge($tab_a, $tab_b, $tab_c);
                        }
                    }

                    $i_debut = -1;
                    $i_fin = count($x) - 1;
                }
            }
        }

        $x = array_reverse($x);
        $chaine = implode($x);
        return $chaine;
    }

    public function addChar($chr)
    {
        $this->chaine_traitee = $chr . $this->chaine_traitee;
    }
}


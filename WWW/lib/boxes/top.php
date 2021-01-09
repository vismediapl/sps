<?

if(file_exists('modules/'.$_GET['module'].'.php') && $_GET['module']!='default') {
  $photo_id = rand(1,3);
} else $photo_id = 0;

?>


<div style="width: 950px; background: #f50035; margin: auto;">

<table width="950" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="3" align="right" class="Top">
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center"><a href="index.php" class="TopLink">strona g³ówna</a></td>
		<td align="center"><a href="tellafriend.php" class="TopLink">poleæ stronê znajomym</a></td>
		<td align="center"><a href="#" onclick="addbookmark();" class="TopLink">dodaj do ulubionych</a></td>
		<td align="center"><a href="rss.xml" class="TopLink">subskrybuj RSS</a></td>
		<td align="center"><a href="sitemap.php" class="TopLink">mapa strony</a></td>
		<td align="center"><a href="http://www.forumsps.pl" class="TopLink">forum</a></td>
		<td align="center"><a href="s80_archiwum.html" class="TopLink">archiwum</a></td>
	</tr>
</table>
		</td>
	</tr>
	<tr>
		<td>
			<img id="top_03" src="themes/<?=$cfg['theme'];?>/gfx/top_03.png" width="239" height="115" alt="" /></td>
		<td>
			<img id="top_04" src="themes/<?=$cfg['theme'];?>/gfx/top_04.png" width="408" height="115" alt="" /></td>
		<td>
			<img id="top_05" src="themes/<?=$cfg['theme'];?>/gfx/photo_top/photo_top_<?=$photo_id;?>.jpg" width="303" height="115" alt="" /></td>
	</tr>
</table>

<?

$dla_gkrpa = '<div class="section">
                	<a class="item3 arrow" href="s74_dla_gkrpa.html">Dla GKRPA</a>
                    <span class="item3 arrow gray">Szkolenia ogólnopolskie 3-5 dniowe</span>
                	<a class="item3 arrow" href="s62_z_wiosna_w_komisjach.html">"Z wiosn± w Komisjach"</a>
                    <a class="item3 arrow" href="s63_lato_w_komisjach.html">"Lato w Komisjach"</a>
                    <a class="item3 arrow" href="s64_jesien_w_komisjach.html">"Jesieñ w Komisjach"</a>
	                <a class="item3 arrow" href="s65_zima_w_komisjach.html">"Zima w Komisjach"</a>
                    <span class="item3 arrow gray">Szkolenia wojewódzkie 1 dniowe</span>
                    <span class="item3 arrow gray2">Szkolenia dla Cz³onków Gminnych Komisji Rozwi±zywania Problemów Alkoholowych</span>
                	<a class="item3 arrow" href="s66_praca_komisji_rozwiazywania_problemow_alkoholowych_w_praktyce.html">"Praca Komisji Rozwi±zywania Problemów Alkoholowych w praktyce"</a>	 
                    <span class="item3 arrow gray">Szkolenia jednodniowe organizowane na terenie Miast i Gmin</span>
                	<a class="item3 arrow" href="s88_finansowanie_zadan_przez_jst_z_zakresu_przeciwdzialania_alkoholizmowi_narkomanii_oraz_przeciwdzialania_przemocy_odpowiedzialnosc_za_wykonywanie_zadan_i_prowadzenie_gospodarki_finansowej.html">"Finansowanie zadañ przez jednostki samorz±du terytorialnego z zakresu przeciwdzia³ania alkoholizmowi, narkomanii oraz przeciwdzia³ania przemocy. Odpowiedzialno¶æ za wykonywanie zadañ i prowadzenie gospodarki finansowej"</a>
                	<a class="item3 arrow" href="s35_blok_dotyczacy_uzaleznienia_picia_problemowego_wspoluzaleznienia_i_motywowania_do_leczenia.html">"Blok dotycz±cy uzale¿nienia, picia problemowego, wspó³uzale¿nienia i motywowania do leczenia"</a>
                    <a class="item3 arrow" href="s37_blok_dotyczacy_zjawiska_przemocy_domowej.html">"Blok dotycz±cy zjawiska przemocy domowej"</a>
                    <a class="item3 arrow" href="s38_blok_dotyczacy_pomocy_psychologicznej_dzieciom_z_rodzin_z_problemem_alkoholowym.html">"Blok dotycz±cy pomocy psychologicznej dzieciom z rodzin z problemem alkoholowym"</a>
                    <a class="item3 arrow" href="s39_blok_dotyczacy_oddzialywan_profilaktycznych_realizowanych_w_srodowisku_szkolnym_rodzinnym_i_srodowiskowym.html">"Blok dotycz±cy oddzia³ywañ profilaktycznych realizowanych w ¶rodowisku szkolnym, rodzinnym i ¶rodowiskowym"</a>
                    <a class="item3 arrow" href="s40_blok_dotyczacy_zagadnien_prawnych_zwiazanych_z_realizacja_zadan_wynikajacych_z_ustawy_o_wychowaniu_w_trzezwosci_przeciwdzialaniu_alkoholizmowi.html">"Blok dotycz±cy zagadnieñ prawnych zwi±zanych z realizacja zadañ wynikaj±cych z ustawy o wychowaniu w trze¼wo¶ci i przeciwdzia³aniu alkoholizmowi"</a>
                    <a class="item3 arrow" href="s94_nowe_trendy_w_zazywaniu_substancji_psychoaktywnych_przez_mlodziez_a_przeciwdzialanie_narkomanii_w_praktyce.html">"Nowe trendy w za¿ywaniu substancji psychoaktywnych przez m³odzie¿ - a przeciwdzia³anie narkomanii w praktyce"</a>
                    <a class="item3 arrow" href="s95_wspolczesne_zagrozenia_dla_rozwoju_psychospolecznego_dzieci_i_mlodziezy.html">"Wspó³czesne zagro¿enia dla rozwoju psychospo³ecznego dzieci i m³odzie¿y"</a>
                    <a class="item3 arrow" href="s96_kontrola_przedsiebiorcow_prowadzacych_dzialalnosc_polegajaca_na_sprzedazy_detalicznej_napojow_alkoholowych_w_kontekscie_watpliwosci_zwiazanych_z_praktycznym_stosowaniem_przepisow_ustawy_o_wychowaniu_w_trzezwosci_i_przeciwdzialaniu_alkoholizmowi_oraz_ustawy_o_swobodzie_dzialalnosci_gospodarczej.html">"Kontrola przedsiêbiorców prowadz±cych dzia³alno¶æ polegaj±c± na sprzeda¿y detalicznej napojów alkoholowych, w kontek¶cie w±tpliwo¶ci zwi±zanych z praktycznym stosowaniem przepisów ustawy o wychowaniu w trze¼wo¶ci i przeciwdzia³aniu alkoholizmowi oraz ustawy o swobodzie dzia³alno¶ci gospodarczej"</a>
                    <a class="item3 arrow" href="s97_wydawanie_cofanie_i_kontrola_zasad_i_warunkow_korzystania_z_zezwolen_na_sprzedaz_napojow_alkoholowych_jak_rowniez_system_wnoszenia_oplat_za_wspomniane_zezwolenia_w_swietle_obowiazujacych_i_planowanych_przepisow_ustawy_o_wychowaniu_w_trzezwosci_i_przeciwdzialaniu_alkoholizmowi_oraz_innych_przepisow.html">"Wydawanie, cofanie i kontrola zasad i warunków korzystania z zezwoleñ na sprzeda¿ napojów alkoholowych, jak równie¿ system wnoszenia op³at za wspomniane zezwolenia, w ¶wietle obowi±zuj±cych i planowanych przepisów ustawy o wychowaniu w trze¼wo¶ci i przeciwdzia³aniu alkoholizmowi oraz innych przepisów"</a>
                    <a class="item3 arrow" href="s41_przeciwdzialanie_alkoholizmowi_w_srodowisku_lokalnym_w_oparciu_o_przepisy_obowiazujacego_prawa.html">"Przeciwdzia³anie alkoholizmowi w ¶rodowisku lokalnym w oparciu o przepisy obowi±zuj±cego prawa"</a>
                    <a class="item3 arrow" href="s42_przeciwdzialanie_przemocy_w_srodowisku_lokalnym_w_oparciu_o_przepisy_obowiazujacego_prawa.html">"Przeciwdzia³anie przemocy w ¶rodowisku lokalnym w oparciu o przepisy obowi±zuj±cego prawa"</a>
                    <a class="item3 arrow" href="s43_przeciwdzialanie_narkomanii_w_srodowisku_lokalnym_w_oparciu_o_przepisy_obowiazujacego_prawa.html">"Przeciwdzia³anie narkomanii w ¶rodowisku lokalnym w oparciu o przepisy obowi±zuj±cego prawa"</a>
                    <span class="item3 arrow gray2">Szkolenia dla sprzedawców i w³a¶cicieli punktów sprzeda¿y napojów alkoholowych</span>
                    <a class="item3 arrow" href="s44_przeciwdzialanie_sprzedazy_alkoholu_nieletnim_w_oparciu_o_przepisy_obowiazujacego_prawa.html">"Przeciwdzia³anie sprzeda¿y alkoholu nieletnim w oparciu o przepisy obowi±zuj±cego prawa"</a>
                    <a class="item3 arrow" href="s45_odpowiedzialny_sprzedawca.html">"Odpowiedzialny sprzedawca"</a>
                </div>
';

$dla_ops = '<div class="section">
                	<a class="item3 arrow" href="s75_dla_ops.html">Dla OPS</a>
                	<a class="item3 arrow" href="s101_wsparcie_ops_pcpr_rops_przy_realizacji_efs.html">Wsparcie OPS przy EFS</a>
                    <span class="item3 arrow gray">Szkolenia ogólnopolskie 3-5 dniowe</span>
                	<a class="item3 arrow" href="s69_prawo_w_praktyce_3_5_dniowe.html">"Prawo w praktyce"</a>
                	<a class="item3 arrow" href="s89_rachunkowosc_jednostek_pomocy_spolecznej_w_praktyce_3_5_dniowe.html">"Rachunkowo¶æ jednostek pomocy spo³ecznej w praktyce"</a>
                    <span class="item3 arrow gray">Szkolenia wojewódzkie 1 dniowe</span>
                	<a class="item3 arrow" href="s70_prawo_w_praktyce_1_dniowe.html">"Prawo w praktyce"</a>
                	<a class="item3 arrow" href="s100_rachunkowosc_jednostek_pomocy_spolecznej_w_praktyce_1_dniowe.html">"Rachunkowo¶æ jednostek pomocy spo³ecznej w praktyce"</a>
                    <span class="item3 arrow gray">Szkolenia jednodniowe organizowane na terenie Miast i Gmin</span>
                	<a class="item3 arrow" href="s36_realizacja_zadan_z_zakresu_pomocy_spolecznej.html">"Realizacja zadañ z zakresu pomocy spo³ecznej"</a>
                </div>
';

$dla_mg = '<div class="section">
                	<a class="item3 arrow" href="s76_dla_miast_i_gmin.html">Dla Miast/Gmin</a>
                    <span class="item3 arrow gray">Szkolenia ogólnopolskie i wojewódzkie 3-5 dniowe</span>
                	<a class="item3 arrow" href="s62_z_wiosna_w_komisjach.html">"Z wiosn± w Komisjach"</a>
                    <a class="item3 arrow" href="s63_lato_w_komisjach.html">"Lato w Komisjach"</a>
                    <a class="item3 arrow" href="s64_jesien_w_komisjach.html">"Jesieñ w Komisjach"</a>
	                <a class="item3 arrow" href="s65_zima_w_komisjach.html">"Zima w Komisjach"</a>
                	<a class="item3 arrow" href="s69_prawo_w_praktyce_3_5_dniowe.html">"Prawo w praktyce"</a>	 
                	<a class="item3 arrow" href="s89_rachunkowosc_jednostek_pomocy_spolecznej_w_praktyce_3_5_dniowe.html">"Rachunkowo¶æ jednostek pomocy spo³ecznej w praktyce"</a>
                    <span class="item3 arrow gray">Szkolenia ogólnopolskie i wojewódzkie 1 dniowe</span>
                	<a class="item3 arrow" href="s66_praca_komisji_rozwiazywania_problemow_alkoholowych_w_praktyce.html">"Praca Komisji Rozwi±zywania Problemów Alkoholowych w praktyce"</a>
                	<a class="item3 arrow" href="s70_prawo_w_praktyce_1_dniowe.html">"Prawo w praktyce"</a>
                	<a class="item3 arrow" href="s100_rachunkowosc_jednostek_pomocy_spolecznej_w_praktyce_1_dniowe.html">"Rachunkowo¶æ jednostek pomocy spo³ecznej w praktyce"</a>
                    <span class="item3 arrow gray">Szkolenia jednodniowe organizowane na terenie Miast i Gmin</span>
                    <span class="item3 arrow gray2">Szkolenia dla radnych, urzêdników wydzia³ów polityki spo³ecznej urzêdów miast i gmin</span>
                	<a class="item3 arrow" href="s88_finansowanie_zadan_przez_jst_z_zakresu_przeciwdzialania_alkoholizmowi_narkomanii_oraz_przeciwdzialania_przemocy_odpowiedzialnosc_za_wykonywanie_zadan_i_prowadzenie_gospodarki_finansowej.html">"Finansowanie zadañ przez jednostki samorz±du terytorialnego z zakresu przeciwdzia³ania alkoholizmowi, narkomanii oraz przeciwdzia³ania przemocy. Odpowiedzialno¶æ za wykonywanie zadañ i prowadzenie gospodarki finansowej"</a>
                	<a class="item3 arrow" href="s46_przeciwdzialanie_alkoholizmowi_oraz_narkomanii_jako_elementy_polityki_spolecznej_realizowanej_na_poziomie_samorzadu_gminnego.html">"Przeciwdzia³anie alkoholizmowi oraz narkomanii jako elementy polityki spo³ecznej realizowanej na poziomie samorz±du gminnego"</a>
                    <a class="item3 arrow" href="s47_przeciwdzialanie_narkomanii_jako_elementy_polityki_spolecznej_realizowanej_na_poziomie_samorzadu_gminnego.html">"Przeciwdzia³anie narkomanii jako elementy polityki spo³ecznej realizowanej na poziomie samorz±du gminnego"</a>
                </div>
';

$dla_naucz = '<div class="section">
                	<a class="item3 arrow" href="s77_dla_nauczycieli.html">Dla nauczycieli</a>
                    <span class="item3 arrow gray">Szkolenia ogólnopolskie i wojewódzkie 1 dniowe</span>
                	<a class="item3 arrow" href="s67_profilaktyka_w_praktyce.html">"Profilaktyka w praktyce"</a>
                	<a class="item3 arrow" href="s68_procedury_w_praktyce.html">"Procedury w praktyce"</a>
                    <span class="item3 arrow gray">Szkolenia jednodniowe organizowane na terenie Miast i Gmin</span>
                    <a class="item3 arrow" href="s94_nowe_trendy_w_zazywaniu_substancji_psychoaktywnych_przez_mlodziez_a_przeciwdzialanie_narkomanii_w_praktyce.html">"Nowe trendy w za¿ywaniu substancji psychoaktywnych przez m³odzie¿ - a przeciwdzia³anie narkomanii w praktyce"</a>
                    <a class="item3 arrow" href="s95_wspolczesne_zagrozenia_dla_rozwoju_psychospolecznego_dzieci_i_mlodziezy.html">"Wspó³czesne zagro¿enia dla rozwoju psychospo³ecznego dzieci i m³odzie¿y"</a>
                    <a class="item3 arrow" href="s48_przeciwdzialanie_narkomanii_w_szkole_w_oparciu_o_przepisy_obowiazujacego_prawa.html">"Przeciwdzia³anie narkomanii w szkole w oparciu o przepisy obowi±zuj±cego prawa"</a>
                	<a class="item3 arrow" href="s49_przeciwdzialanie_przemocy_w_szkole_w_oparciu_o_przepisy_obowiazujacego_prawa.html">"Przeciwdzia³anie przemocy w szkole w oparciu o przepisy obowi±zuj±cego prawa"</a>
                	<a class="item3 arrow" href="s50_hivaids_a_ryzykowne_zachowania_bezpiecznie_bez_leku_jak_rozmawiac_o_tym_w_szkole.html">"HIV/AIDS a ryzykowne zachowania. Bezpiecznie, bez lêku - jak rozmawiaæ o tym w szkole..."</a>
                	<a class="item3 arrow" href="s51_zadania_koordynatora_ds_bezpieczenstwa_w_kontekscie_lokalnej_strategii_przeciwdzialania_przemocy.html">"Zadania koordynatora ds. bezpieczeñstwa w kontek¶cie lokalnej strategii przeciwdzia³ania przemocy"</a>
                	<a class="item3 arrow" href="s52_przeciwdzialanie_narkomanii_w_szkole.html">"Przeciwdzia³anie narkomanii w szkole"</a>
                	<a class="item3 arrow" href="s53_przeciwdzialanie_przemocy_w_szkole.html">"Przeciwdzia³anie przemocy w szkole"</a>
                    <span class="item3 arrow gray2">Wywiadówki profilaktyczne dla rodziców</span>
                	<a class="item3 arrow" href="s59_profilaktyka_narkomanii_w_domu_i_w_szkole_jak_skutecznie_uchronic_dziecko_przed_narkotykami.html">"Profilaktyka narkomanii w domu i w szkole. Jak skutecznie uchroniæ dziecko przed narkotykami?"</a>
                	<a class="item3 arrow" href="s60_jak_rozpoznac_czy_dziecko_jest_ofiara_przemocy_lub_przesladowania_.html">"Jak rozpoznaæ, czy dziecko jest ofiar± przemocy lub prze¶ladowania w szkole?"</a>
                    <span class="item3 arrow gray2">Programy dla dzieci i m³odzie¿y</span>
                	<a class="item3 arrow" href="s93_trzy_zywioly_powietrze.html">"Trzy ¿ywio³y - powietrze"</a>
                	<a class="item3 arrow" href="s55_trzy_zywioly_ogien.html">"Trzy ¿ywio³y - ogieñ"</a>
                	<a class="item3 arrow" href="s56_trzy_zywioly_woda.html">"Trzy ¿ywio³y - woda"</a>
                	<a class="item3 arrow" href="s57_bezpieczna_trzezwa_ciaza.html">"Bezpieczna - trze¼wa ci±¿a"</a>
                	<a class="item3 arrow" href="s58_bezpieczny_trzezwy_kierowca.html">"Bezpieczny - trze¼wy kierowca"</a>
                </div>
';

$dla_mlod = '<div class="section">
                	<a class="item3 arrow" href="s78_dla_mlodziezy.html">Dla m³odzie¿y</a>
                	<a class="item3 arrow" href="s93_trzy_zywioly_powietrze.html">"Trzy ¿ywio³y - powietrze"</a>
                	<a class="item3 arrow" href="s55_trzy_zywioly_ogien.html">"Trzy ¿ywio³y - ogieñ"</a>
                	<a class="item3 arrow" href="s56_trzy_zywioly_woda.html">"Trzy ¿ywio³y - woda"</a>
                	<a class="item3 arrow" href="s57_bezpieczna_trzezwa_ciaza.html">"Bezpieczna - trze¼wa ci±¿a"</a>
                	<a class="item3 arrow" href="s58_bezpieczny_trzezwy_kierowca.html">"Bezpieczny - trze¼wy kierowca"</a>
				</div>
';

?>

<table cellspacing="0" cellpadding="0" id="menu1" class="ddmx" style="margin: auto;">
    <tr>
        <td>
            <a class="item1" href="index.php">Strona g³ówna</a>
        </td>
        
        <td>
            <a class="item1" href="s11_o_nas.html">O nas</a>
			<div class="section">
                <a class="item2 arrow" href="s11_o_nas.html">O nas</a>
			</div>
        </td>
        
        <td>
            <a class="item1" href="s31_kadra.html">Kadra</a>
			<div class="section">
                <a class="item2 arrow" href="s31_kadra.html">Kadra</a>
			</div>
        </td>
        
        <td>
            <a class="item1" href="s33_oferta_sps.html"><img src="themes/<?=$cfg['theme']?>/gfx/multimenu/arrow.png" alt="" border="0" /> Oferta</a>
            <div class="section">
                <a class="item2 arrow" href="s33_oferta_sps.html">Oferta SPS</a>
				<a class="item2 arrow" href="s74_dla_gkrpa.html">Dla GKRPA<img src="themes/<?=$cfg['theme']?>/gfx/multimenu/arrow1.gif" alt="" /></a>
				<?=$dla_gkrpa;?>
                <a class="item2 arrow" href="s75_dla_ops.html">Dla OPS<img src="themes/<?=$cfg['theme']?>/gfx/multimenu/arrow1.gif" alt="" /></a>
                <?=$dla_ops;?>
				<a class="item2 arrow" href="s74_dla_gkrpa.html">Dla Miast/Gmin<img src="themes/<?=$cfg['theme']?>/gfx/multimenu/arrow1.gif" alt="" /></a>
				<?=$dla_mg;?>
				<a class="item2 arrow" href="s77_dla_nauczycieli.html">Dla nauczycieli<img src="themes/<?=$cfg['theme']?>/gfx/multimenu/arrow1.gif" alt="" /></a>
				<?=$dla_naucz;?>
				<a class="item2 arrow" href="s78_dla_mlodziezy.html">Dla m³odzie¿y<img src="themes/<?=$cfg['theme']?>/gfx/multimenu/arrow1.gif" alt="" /></a>
				<?=$dla_mlod;?>
            </div>
        </td>
        
        <td>
            <a class="item1" href="s74_dla_gkrpa.html"><img src="themes/<?=$cfg['theme']?>/gfx/multimenu/arrow.png" alt="" border="0" /> Dla GKRPA</a>
			<?=$dla_gkrpa;?>
        </td>
        
        <td>
            <a class="item1" href="s75_dla_ops.html"><img src="themes/<?=$cfg['theme']?>/gfx/multimenu/arrow.png" alt="" border="0" /> Dla OPS</a>
            <?=$dla_ops;?>
        </td>
        
        <td>
            <a class="item1" href="s76_dla_miast_i_gmin.html"><img src="themes/<?=$cfg['theme']?>/gfx/multimenu/arrow.png" alt="" border="0" /> Dla Miast/Gmin</a>
            <?=$dla_mg;?>
        </td>
        
        <td>
            <a class="item1" href="s77_dla_nauczycieli.html"><img src="themes/<?=$cfg['theme']?>/gfx/multimenu/arrow.png" alt="" border="0" /> Dla nauczycieli</a>
            <?=$dla_naucz;?>
        </td>
        
        <td>
            <a class="item1" href="s78_dla_mlodziezy.html"><img src="themes/<?=$cfg['theme']?>/gfx/multimenu/arrow.png" alt="" border="0" /> Dla m³odzie¿y</a>
            <?=$dla_mlod;?>
        </td>
        <td>
            <a class="item1" href="contractors.php">Kontrahenci</a>
        </td>
        <td>
            <a class="item1" href="s12_kontakt.html">Kontakt</a>
        </td>
    </tr>
    </table>

    <script type="text/javascript">
    var ddmx = new DropDownMenuX('menu1');
    ddmx.delay.show = 0;
    ddmx.delay.hide = 400;
    ddmx.position.levelX.left = 2;
    ddmx.init();
    </script>
</div>
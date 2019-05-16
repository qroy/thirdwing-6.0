<?php
$date = format_date($node->created, 'custom', 'F Y');
?>
<style type="text/css" media="screen">
      table {
        margin: 0;
      }
      td {
        padding: 0;
      }
      tbody {
        border: 0px none #ffffff;
      }

      a img {
         border: none;
      }

      a {
         border: none;
      }

      td.permission {
         padding: 30px 0 20px 0;
      }

      .header {
         background: transparent url('http://www.thirdwing.nl/sites/all/themes/thirdwing/images/bg-nws-2013.jpg');
      }

      .date {
        background-color: #ffffff;
      }
      td.date {
        padding: 10px 5px 10px 5px;
      }
      .date p {
      	font-family: Verdana;
      	font-size: 10px;
      	font-weight: bold;
        color: #000000;
      	display: inline;
      }

      .body {
         background-color: #ffffff;
      }

      td.mainbar {
      	padding: 22px 5px 0 5px;
      	text-align: left;
      }

      .mainbar p {
      	font-family: Verdana;
      	font-size: 12px;
      	color: #000000;
      	margin: 0 0 10px 0;
      	text-align: left;
      }
      .mainbar p a {
      	color: #a75859;
      }
      .mainbar ul a {
      	font-family: Verdana;
      	font-size: 12px;
      	color: #a75859;
      }
      td.contact {
      	font-family: Verdana;
      	font-size: 10px;
        color: #ffffff;
        background: transparent url('http://www.thirdwing.nl/sites/all/themes/thirdwing/images/bg-nws-2013.jpg');
        padding: 5px;
      }
      td.contact a {
        color: #ffffff;
      }
      td.footer {
      	padding: 10px 0 10px 0;
      	border-top: 2px solid #cccccc;
      }

      .footer p {
      	color: #666666;
      	font-size: 11px;
      	margin: 0;
      	padding: 0;
      }

      .footer a {
      	font-family: Verdana;
      	font-size: 11px;
      	color: #a75859;
      }
</style>

<table width="100%" cellspacing="0" cellpadding="0">
   <tr>
      <td align="center">
         <table width="700" cellspacing="0" cellpadding="0">
            <tr>
               <td colspan="2" align="center" class="permission"></td>
            </tr>
            <tr>
               <td height="130" align="left" class="header">
                  <table width="570" border="0" cellspacing="0" cellpadding="0">
                     <tr>
                        <td><img src="http://www.thirdwing.nl/sites/all/themes/thirdwing/images/header-nws-2013.jpg" width="570" height="130" alt="Vrienden van Thirdwing Nieuwsbrief"></td>
                     </tr>
                  </table>
               </td>
               <td height="130" align="left" class="header">
                  <table width="130" border="0" cellspacing="0" cellpadding="0">
                     <tr>
                        <td><img src="http://www.thirdwing.nl/sites/all/themes/thirdwing/images/logo-nws-2013.jpg" width="130" height="130" alt="Thirdwing Heerlen"></td>
                     </tr>
                  </table>
               </td>
            </tr>
            <tr>
               <td align="left" class="date">
                  <p>Jaargang <?php print $node->field_jaargang[0]['value'] ?>, uitgave <?php print $node->field_uitgave[0]['value'] ?></p>
               </td>
               <td align="right" class="date">
                  <p><?php print $date; ?></p>
               </td>
            </tr>
          </table>
      </td>
   </tr>
   <tr>
      <td align="center">
         <table width="700" cellspacing="0" cellpadding="0" class="body">
            <tr>               
               <td align="center" valign="top" class="mainbar" align="left">
                  <?php print $content; ?>
               </td>
               <td align="center" valign="top" class="mainbar" align="right">
                  <table width="200" border="0" cellspacing="0" cellpadding="0">
                     <tr>
                        <td><img src="http://www.thirdwing.nl/sites/all/themes/thirdwing/images/groep-nws.jpg" width="200" height="148" alt="Poster Thirdwing" border="0" vspace="4" /></td>
                     </tr>
                  </table>
               </td>
            </tr>
            <tr>
               <td align="center" valign="top" class="mainbar" align="left" colspan="2">
                 <hr>
                 <a name="top"></a><h2>Inhoud</h2>
                 <p>De volgende onderwerpen komen aan bod in deze uitgave van de Nieuwsbrief voor de Vrienden van Thirdwing:</p>
                 <ul>
                 <?php 
                  $output = views_embed_view('nieuwsbrief', 'block_2', $node->nid);
                  if ($output){
                   print $output;
                  }
                 ?>
                 </ul>
               </td>
            </tr>
          </table>

      <?php 
       $output = views_embed_view('nieuwsbrief', 'block_1', $node->nid);
       if ($output){
        print $output;
       }
      ?>

       </td>
   </tr>
   <tr>
       <td align="center">
     <table width="700" border="0" cellspacing="0" cellpadding="0">
        <tr>
           <td width="25%" valign="top" class="contact" align="center"><a href="http://www.thirdwing.nl/node/540">Onze Vrienden</td>
           <td width="25%" valign="top" class="contact" align="center"><a href="http://www.thirdwing.nl">www.thirdwing.nl</a></td>
           <td width="25%" valign="top" class="contact" align="center"><a href="mailto:info@thirdwing.nl">info@thirdwing.nl</a><br />tel. 045 - 5 22 14 27</td>
           <td width="25%" valign="top" class="contact" align="center">Rabobank Heerlen 14.60.25.253</td>
        </tr>
     </table>

     <table width="700" border="0" cellspacing="0" cellpadding="0">
         <tr>
            <td class="footer" align="center">
  <p>Alleen de Vrienden van Thirdwing ontvangen deze nieuwsbrief als dank voor hun steun.</p><p>Heeft u desondanks geen interesse (meer) in de nieuwsbrief? Klik dan op <a href="[simplenews-unsubscribe-url]">uitschrijven</a>.</p>
            </td>
        </tr>
     </table>

 </td></tr>
</table>
<?php
// $Id: simplenews-newsletter-footer.tpl.php,v 1.4 2009/09/30 14:10:20 sutharsan Exp $

/**
 * @file
 * Default theme implementation to format the simplenews newsletter footer.
 * 
 * Copy this file in your theme directory to create a custom themed footer.
 * Rename it to simplenews-newsletter-footer--<tid>.tpl.php to override it for a 
 * newsletter using the newsletter term's id.
 *
 * Available variables:
 * - $node: newsletter node object
 * - $language: language object
 * - $key: email key [node|test]
 * - $format: newsletter format [plain|html]
 * - $unsubscribe_text: unsubscribe text
 * - $test_message: test message warning message
 *
 * Available tokens:
 * - [confirm-unsubscribe-url]: unsubscribe url to be used as link
 * for more tokens: see simplenews_mail_tokens()
 *
 * @see template_preprocess_simplenews_newsletter_footer()
 */
?>

     <table width="700" border="0" cellspacing="0" cellpadding="0">
        <tr>
           <td width="25%" valign="top" class="contact" align="center"><a href="http://www.thirdwing.nl/node/540">Onze Vrienden</td>
           <td width="25%" valign="top" class="contact" align="center"><a href="http://www.thirdwing.nl">www.thirdwing.nl</a></td>
           <td width="25%" valign="top" class="contact" align="center"><a href="mailto:info@thirdwing.nl">info@thirdwing.nl</a><br />tel. 045 - 5 22 14 27</td>
           <td width="25%" valign="top" class="contact" align="center">Rabobank Heerlen IBAN NL84 RABO 0146 0252 53</td>
        </tr>
     </table>

     <table width="700" border="0" cellspacing="0" cellpadding="0">
         <tr>
            <td class="footer" align="center">

<?php if ($format == 'html'): ?>
  <p>Alleen de Vrienden van Thirdwing ontvangen deze nieuwsbrief als dank voor hun steun.</p><p>Heeft u desondanks geen interesse (meer) in de nieuwsbrief? Klik dan op <a href="[simplenews-unsubscribe-url]">uitschrijven</a>.</p>
<?php else: ?>
-- Alleen de Vrienden van Thirdwing ontvangen deze nieuwsbrief als dank voor hun steun. Heeft u desondanks geen interesse (meer) in de nieuwsbrief? Klik dan op [simplenews-unsubscribe-url]
<?php endif ?>

<?php if ($key == 'test'): ?>
- - - <?php print $test_message ?> - - -
<?php endif ?>

            </td>
        </tr>
     </table>

 </td></tr>
</table>

</body>
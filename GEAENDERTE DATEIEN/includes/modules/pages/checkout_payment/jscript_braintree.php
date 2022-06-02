<?php
/**
 * jscript_braintree
 * show braintree cc input fields only when braintree cc is selected
 * Zen Cart German Specific
 * @copyright Copyright 2003-2022 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: jscript_braintree.php for Sepa Lastschrift 2022-02-26 16:22:16Z webchills $
 */
?>
<script type="text/javascript"><!--
    $(function() {
   $("input[name='payment']").click(function() {
     if ($("#pmt-braintree_api").is(":checked")) {
       $(".ccinfobraintree").show();
     } else {
       $(".ccinfobraintree").hide();
     }
     if ($("#pmt-sepalastschrift").is(":checked")) {
       $(".ccinfosepa").show();
     } else {
       $(".ccinfosepa").hide();
     }
      if ($("#pmt-sepalastschrifteu").is(":checked")) {
       $(".ccinfosepaeu").show();
     } else {
       $(".ccinfosepaeu").hide();
     }
   });
 });
//--></script>

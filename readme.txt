=== Zapier Proxy for WishList Member ===
Contributors: macbookandrew
Tags: membership, wishlist, wishlist member, zapier
Donate link: https://cash.me/$AndrewRMinionDesign
Requires at least: 4.3
Tested up to: 4.8
Stable tag: 1.0.0
License: GPL2

Integrates Zapier with WishList Member generic shopping cart

== Description ==
Integrates Zapier with WishList Member generic shopping cart so customers are automatically given access.

== Installation ==
1. Install this plugin
1. Enable the Generic Shopping Cart in WishList Member
    1. Go to WishList Member > Integration and choose the “Shopping Cart” tab
    1. Click on the gear icon next to the “Set Shopping Cart” button
    1. Ensure that “Generic” is enabled and press the “Update Shopping Carts” button
    1. Choose “Generic” from the dropdown menu and press the “Set Shopping Cart” button
    1. Make a note of the last segment of the “Post To URL” (you’ll need the characters after “register/”)
    1. Make sure you have SKUs set up for the appropriate membership level(s)
1. Log in to your Zapier account and create a zap
1. Set your trigger as desired
1. For the Action step, use “Webhooks” and choose “POST”
1. Set the URL to `http://yourwebsite.com/wp-admin/admin-post.php?action=wlm_zapier_create_account&key=XXXXXX` (update `http://yourwebsite.com` to match your site’s URL and replace “XXXXXX” with the last segment of your “Post To URL”)
1. Set the “Payload Type” to “Form”
1. Add these fields under “Data”:
    1. `transaction_id`: transaction ID (if provided by your trigger) or random string of text
    1. `lastname`: contact’s last name
    1. `firstname`: contact’s firstname
    1. `email`: contact’s email address
    1. `level`: the SKU for your WishList Member Membership Level

== Changelog ==

= 1.0.0 =
 - First stable version

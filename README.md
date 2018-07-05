# Yireo ExampleAddressFieldComment
This module integrates a new fields (`comment`) in various ways in the existing fieldsets of a shipment address. The `comment` field follows the pattern of a Custom Attribute (EAV value).

- Setup procedure
- Shipment Address step in the checkout
- Address form under the Customer Account

### Installation
```
composer require yireo-training/magento2-example-address-field-comment:dev-master
```

### Setup procedure
Through a file `Setup/InstallData.php` the field `comment` is added to the database, plus it is added to some forms in the backend. Right after this step, you can already enter and save values for this Custom Attribute `comment` in the backend.

### Address form under the Customer Account
This is actually bad code: While the customer-entity can be cleanly extended using a form API, the address form is not easy to extend: Its fields are hard-coded in PHTML. Therefore, a plugin was created (`etc/di.xml`) to hack the new field `comment` (`Block/Address/Edit/Field/Comment.php`) into the right place. 

The block-class calls for the `comment` value through the Custom Attribute code.
 
### Shipment Address step in the checkout
The `comment` value is added automatically to the checkout, because it is a Custom Attribute. This method is the recommended approach for simple values.

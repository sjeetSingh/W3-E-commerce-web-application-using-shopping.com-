## An E-commerce Web Application using PHP

###Overview###
A Web application where users can shop for electronics products (like Laptops, Speakers, Computers, and other accessories). 

###Description:###
In this application, the user can:


1.  Search the item(s):
    * using the keyword (e.g. Sony laptop, Apple, etc.) 
    * select the category of the product the user is looking (e.g. laptops, speaker, computers, RAM, etc.)
2. Put the selected items in the cart.
3. Delete the items present in the cart.
4. Empty the cart.

The above functioanlity is implemented in PHP. The prodcuts and the metadata about it is fetched from the shopping.com API (eBay Commer Network API or ECN API). 
Product category (such as Computer Accessories, Software Storage, Hardware, Input, etc.) is fetched using [**Get Category Tree by ID**](http://developer.ebaycommercenetwork.com/docs/API_Use_Cases#34). The list of different types of electronic items in each category is fetched using the [**Include all descendants in category tree**](http://developer.ebaycommercenetwork.com/docs/API_Use_Cases#35).  
The Search by Keyword feature is implemented by sending the keyword as a parameter to shopping.com APIs [**Search By Keyword**](http://developer.ebaycommercenetwork.com/docs/API_Use_Cases#1) url. 

This web application can be found [**HERE**](http://omega.uta.edu/~sgp5369/buyMe.php)




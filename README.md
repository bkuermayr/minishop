# minishop
A php template for online shop and ecommerce webpages
can be used as starter code / template for online shop projects

## Screenshots
<p float="left">
<img src="https://raw.githubusercontent.com/bkuermayr/minishop/master/screenshots/shop.PNG" alt="online shop screenshot" width="400"/>
<img src="https://raw.githubusercontent.com/bkuermayr/minishop/master/screenshots/cart.png" alt="online shop screenshot" width="400"/>
<img src="https://raw.githubusercontent.com/bkuermayr/minishop/master/screenshots/checkout.png" alt="online shop screenshot" width="400"/>
<img src="https://raw.githubusercontent.com/bkuermayr/minishop/master/screenshots/product.png" alt="online shop screenshot" width="400"/>
</p>


## Tech stack
Written in PHP + a little bit JS (AJAX, JQuery)
Styled with Bootstrap + SCSS
Uses MySQL database, interaction via PDO

## Project structure
* /index.php --> starting point of application
* /layout/page-content.php --> main content area that switches between pages, depending on pageid in URL (?pageid=xxx)
* /functions/minishop_dbms.php --> handles all interaction with database, also includes create scripts
* /layout --> header, footer, page-content, etc.
* /forms --> login form, signup form, etc.
* /css/style.scss --> custom stylesheet (must be compiled to /css/style.css)
* /screenshots --> for more screenshots, that show all implemented features

As we have four pages that all apply to albums, we will group 
them in a single controller AlbumController within our Album 
module as four actions. The four actions will be:

Action 	            Controller 	            Page

Home 	            AlbumController 	    index
Add new album 	    AlbumController 	    add
Edit album 	        AlbumController 	    edit
Delete album 	    AlbumController 	    delete

The mapping of a URL to a particular action is done using 
routes that are defined in the module’s module.config.php file. 
We will add a route for our album actions.

URL 	            Page 	                        Action      Method called
/album 	            Home (list of albums) 	        index       Album\Controller\AlbumController::indexAction
/album/add 	        Add new album 	                add         Album\Controller\AlbumController::addAction
/album/edit/2 	    Edit album with an id of 2 	    edit        Album\Controller\AlbumController::editAction
/album/delete/4 	Delete album with an id of 4 	delete      Album\Controller\AlbumController::deleteAction


The database
We will make use of laminas-db's Laminas\Db\TableGateway\TableGateway to find, insert, update, and delete rows from a database table.
We are going to use Sqlite, via PHP's PDO driver.


In order to always use the same instance of our AlbumTable, we will use the ServiceManager to define how to create one. This is most easily done by adding a ServiceManager configuration to the module.config.php which is automatically loaded by the ModuleManager and applied to the ServiceManager. We'll then be able to retrieve the AlbumTable when we need it.
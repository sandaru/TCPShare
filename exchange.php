<?PHP
// MySql connection
include ('connection.php');

$connection = new createConnection(); //i created a new object
$connection->connectToDatabase(); // connected to the database
$connection->selectDatabase();// closed connection

//Main function to run the server
function main()
{
    while (true)
    {
        // set some variables
        $host = "127.0.0.1";
        $port = 25003;
        $request = new request();

        set_time_limit(0);// don't timeout!
        // create socket
        $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
        // bind socket to port
        $result = socket_bind($socket, $host, $port) or die("Could not bind to socket\n");
        // start listening for connections
        $result = socket_listen($socket, 3) or die("Could not set up socket listener\n");

        // accept incoming connections
        // spawn another socket to handle communication
        $spawn = socket_accept($socket) or die("Could not accept incoming connection\n");
        // read client input
        $input = socket_read($spawn, 1024) or die("Could not read input\n");
        // clean up input string

        //Take the input string and split it.
        $input = trim($input);
        echo "Client Message : ".$input;
        $request_string =explode(":",$input)[0];
        $uuid = explode(":",$input)[1];

        //Call the handler
        $request->request_handler($request_string,$uuid);


        $output = "Requests -> ".$request_string." UUID -> ".$uuid;
        socket_write($spawn, $output, strlen ($output)) or die("Could not write output\n");

        // close sockets
        socket_close($spawn);
        socket_close($socket);
    }
}

//Class to handle the requests
class request
{
    public function request_handler($request_string,$uuid)
    {
        switch ($request_string) 
        {
            case 'register':#when registration requested
                #Code
                break;
            case 'available':#when computer is on
                #Code
                break;
            case 'unavailable':#when computer is off
                #Code
                break;
            case 'request':#when user request to connect
                #Code
                break;
            case 'accept':#when authentication granted 
                #Code
                break;
            case 'denied':#when authentication denied 
                #Code
                break;  
            case 'exchange':#when data transition is on
                #Code
                break;       
            default:#when command is not in range 
                echo "Command not in use..";
                break;
        }
    }
}

//Class to handle the database according to the commands
class database 
{
    public function register($username,$uuid)
    {
         mysqli_query($connection->myconn,"INSERT INTO register(user_name,uuid,availability) VALUES('$username','$uuid','false')");
    }

    public function set_availability($state)
    {
        if($state=="true")
            {
                //Change the application state to false
                mysqli_query($connection ->myconn,"UPDATE register SET availability= 'true' WHERE uuid = '$application_ID'");
            }
        else
            {
                //Change the application state to false
                mysqli_query($connection ->myconn,"UPDATE register SET availability= 'false' WHERE uuid = '$application_ID'");
            }
    }
}

class exchange
{
# Handles data exchange between server and client 
    private $state = true;
    public function start_Exchange()
    {
        $this->do_Exchange();
    }

    public function stop_Exchange()
    {
        $this->terminate_Exchange();
    }

    //Open new port for the data exchange
    private function do_Exchange()
    {
        while($state)
        {
            // set some variables
            $host = "127.0.0.1";
            $port = 23000;
            try//Catch port exceptions 
            {
                set_time_limit(0);// don't timeout!
                // create socket
                $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
                // bind socket to port
                $result = socket_bind($socket, $host, $port) or die("Could not bind to socket\n");
                // start listening for connections
                $result = socket_listen($socket, 3) or die("Could not set up socket listener\n");

                // accept incoming connections
                // spawn another socket to handle communication
                $spawn = socket_accept($socket) or die("Could not accept incoming connection\n");
                // read client input
                $input = socket_read($spawn, 1024) or die("Could not read input\n");
                // clean up input string
                $input = trim($input);
                echo "Client Message : ".$input;
                // reverse client input and send back
                $output = "Hello from server"."\n"."you sent ".$input;
                socket_write($spawn, $output, strlen ($output)) or die("Could not write output\n");

                // close sockets
                socket_close($spawn);
                socket_close($socket);
            }
            catch(Exception $e)//If exception occurs while connect to the server 
            {
                if($port < 65000)#if exceed the port numbers
                {
                    $port = $port+1;#check next port is available.
                }
                else
                {
                    $port = 100;#check previous port is available
                }
                return;
            }
        }
    }

    //set $state to false
    private function terminate_Exchange()
    {
        $state = false;
    }
}
main();
?>
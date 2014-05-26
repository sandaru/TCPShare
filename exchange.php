<?PHP
//This scrypt starts a tcp that is exchanging the  

//Main function to run the server
private function main()
{
    while (true)
    {
        // set some variables
        $host = "127.0.0.1";
        $port = 25003;

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
}



?>
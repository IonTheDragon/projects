package com.company;

public class Client {
    public static void main (String args[]) throws InterruptedException  {

        int tcp_port = 0;
        int udp_port = 7005;
        GenerateOrders GenOrd = new GenerateOrders(1);
        Order ord = GenOrd.InitOrder();

        ClientObject FirstClient = new ClientObject(tcp_port, udp_port, GenOrd, ord);
        Thread thr = new Thread(FirstClient);
        thr.start();
    }
}

package com.company;

import java.io.*;
import java.net.Socket;


public class TCPreading {

    Socket clientSocket = null;

    //Поток ввода от клиента, получаем из него сообщения
    InputStream inClientStream = null;

    Orders ServerOrders;

    public void read() {
        //Читаем поток
        Order OrderIn = new Order();
        try {
            inClientStream = clientSocket.getInputStream(); //проходит
            ObjectInputStream reader = new ObjectInputStream(inClientStream); //проходит
            while ((OrderIn = (Order)reader.readObject())!=null) { //Читает строку, но не читает объект
                    ServerOrders.Buy(OrderIn);
                    System.out.println("Заказ получен");
            }
            //System.out.println("Конец чтения");
        } catch (Exception ex) {
            System.out.println(ex.getMessage()); //не видит данные
        }
    }

   public TCPreading(Socket m_clientSocket, Orders m_ServerOrders) {
       clientSocket = m_clientSocket;
       ServerOrders = m_ServerOrders;
    }
}

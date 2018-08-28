package com.company;

import java.io.*;
import java.net.Socket;


public class TCPreading implements Runnable {

    Socket clientSocket = null;

    //Поток ввода от клиента, получаем из него сообщения
    InputStream inClientStream = null;

    Orders ServerOrders;

    @Override
    public void run() {
        int i = 0;
        try {
            while (true) {
                Thread.sleep(1000);
                System.out.println("tst"); //проверка, доходит ли программа до этого места
                if (clientSocket.getInputStream() == null) {
                    Thread.sleep(5000);
                    i++;
                    System.out.println("Нет входящих данных");
                    if (i == 5) break;
                } else {
                    inClientStream = clientSocket.getInputStream();
                    //Читаем поток
                    ObjectInputStream reader = new ObjectInputStream(inClientStream);
                    Order OrderIn = (Order) reader.readObject();
                    ServerOrders.Buy(OrderIn);
                    System.out.println("Заказ получен");
                }
            }
        } catch (Exception ex) {

            System.out.println(ex.getMessage());
        }
    }

   public TCPreading(Socket m_clientSocket, Orders m_ServerOrders) {
       clientSocket = m_clientSocket;
       ServerOrders = m_ServerOrders;
    }
}

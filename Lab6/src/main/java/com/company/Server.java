package com.company;

import com.company.Check.*;
import java.net.*;


public class Server {
    public static void main (String args[]) {

        Orders ServerOrders = new Orders();
        Validate ServerVal = new Validate(6000, 5, ServerOrders, 7005, 7020, "127.0.0.1");
        Thread thr = new Thread(ServerVal);
        thr.start();

        int port = 7020;

        // Создаем сокет для класса проверки статуса и пересылаем сигнал готовности клиенту
        ServerVal.CreateSocket();

        //Проверим доступность порта
        //Создание TCP клиента
        Socket clientSocket = new Socket();
        try {
            ServerSocket serverSocket = new ServerSocket(port);
            clientSocket.setSoTimeout(1000);
            clientSocket = serverSocket.accept();
            System.out.println("TCP клиент создан");
        } catch (Exception e) {
            System.out.println("Ошибка cоздания TCP " + e);
            System.exit(-1);
        }

        TCPreading ClientReader = new TCPreading(clientSocket, ServerOrders);

        //Начать чтение клиента
        System.out.println("Чтение TCP порта");
        ClientReader.read();

    }
}

package com.company;

import com.company.Check.*;

import java.io.IOException;
import java.io.ObjectInputStream;
import java.io.ObjectOutputStream;
import java.net.*;


public class Server {
    public static void main(String args[]) {

        Orders ServerOrders = new Orders();
        Validate ServerVal = new Validate(12000, 8, ServerOrders, 7005, 7020, "127.0.0.1");
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
            clientSocket.setSoTimeout(8000);
            clientSocket = serverSocket.accept();
            System.out.println("TCP клиент создан");

            //Начать чтение клиента
            System.out.println("Чтение TCP порта");

            //Цикл чтения TCP порта
            while (true) {
                //if (thr.isAlive()) {

                    if (clientSocket.isClosed()) {
                        clientSocket = serverSocket.accept();
                    } else {
                        ObjectInputStream deserializer = new ObjectInputStream(clientSocket.getInputStream());
                        Order ord = (Order) deserializer.readObject();
                        ServerOrders.Buy(ord);
                        System.out.println("Заказ получен");
                        ord.OurUser.ReadUser();
                        for (int i = 0; i < ord.PurchasingItemsList.size(); i++) {
                            System.out.println("__________");
                            System.out.println("Идентификатор: " + ord.PurchasingItemsList.get(i).GetId().toString());
                            System.out.println("Тип устройства: " + ord.PurchasingItemsList.get(i).GetDeviceType());
                            System.out.println("Количество: " + ord.PurchasingItemsList.get(i).GetCount());
                            System.out.println("Название: " + ord.PurchasingItemsList.get(i).GetName());
                            System.out.println("Цена: " + ord.PurchasingItemsList.get(i).GetPrice());
                            System.out.println("Изготовитель: " + ord.PurchasingItemsList.get(i).GetCompany());
                            System.out.println("Модель: " + ord.PurchasingItemsList.get(i).GetModel());
                            System.out.println("ОС: " + ord.PurchasingItemsList.get(i).GetOs());
                            if ("Phone".equalsIgnoreCase(ord.PurchasingItemsList.get(i).GetDeviceType())) {
                                System.out.println("Тип корпуса: " + ord.PurchasingItemsList.get(i).GetParam1());
                            } else if ("Smartphone".equalsIgnoreCase(ord.PurchasingItemsList.get(i).GetDeviceType())) {
                                System.out.println("Тип SIM-карты: " + ord.PurchasingItemsList.get(i).GetParam1());
                                System.out.println("Число SIM-карт: " + ord.PurchasingItemsList.get(i).GetParam2());
                            } else if ("Book".equalsIgnoreCase(ord.PurchasingItemsList.get(i).GetDeviceType())) {
                                System.out.println("Процессор: " + ord.PurchasingItemsList.get(i).GetParam1());
                                System.out.println("Разрешение экрана: " + ord.PurchasingItemsList.get(i).GetParam2());
                            }
                        }
                        System.out.println("__________");
                        deserializer.close();
                    }
                //} else System.exit(-1);
            }
        } catch (IOException ex) {
            ex.printStackTrace();
        } catch (ClassNotFoundException ex) {
            System.out.println("Класс не найден");
        } catch (Exception e) {
            e.printStackTrace();
            System.exit(-1);
        }

    }
}

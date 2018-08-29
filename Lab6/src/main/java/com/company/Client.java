package com.company;

import com.company.Devices.*;
import com.company.Check.*;
import com.company.FileManagement.*;
import java.io.*;
import java.net.*;
import java.util.*;
import java.util.regex.*;

public class Client {
    public static void main (String args[]) throws InterruptedException  {

        int ConnectStatus = 0;

        int lind = 1;

        int port = 0;

        String host = "";

        GenerateOrders GenOrd = new GenerateOrders(1);

        Order ord = GenOrd.InitOrder();

        DatagramSocket sock = null;

        try
        {
            sock = new DatagramSocket();

            while(true)
            {

                //буфер для получения входящих данных
                byte[] buffer = new byte[65536];
                DatagramPacket reply = new DatagramPacket(buffer, buffer.length);

                //Получаем данные от сервера
                sock.receive(reply);
                byte[] InputData = reply.getData();
                String s = new String(InputData, 0, reply.getLength());

                if (s.matches("ready")) {
                    System.out.println("Сервер: " + reply.getAddress().getHostAddress() + ", udp порт: " + reply.getPort() + ", получено: " + s);
                    ConnectStatus = 1;
                    host = reply.getAddress().getHostAddress();

                    String REGEX = "ready port"; //убираем пометки из сообщения, оставляя номер tcp порта
                    String INPUT = s;
                    String REPLACE = "";
                    Pattern p = Pattern.compile(REGEX);
                    // получение matcher объекта
                    Matcher m = p.matcher(INPUT);
                    port = Integer.parseInt(m.replaceAll(REPLACE));
                }
                else if (s.equalsIgnoreCase("")) {
                    Thread.sleep(1000);
                }
                else {
                    System.out.println("________________________");
                    System.out.println(s);
                    System.out.println("________________________");

                    //генерация заказа
                    GenOrd.ind = lind;
                    GenOrd.Generate();
                    ord = GenOrd.order;
                    lind ++;
                }

                if(ConnectStatus == 1) {
                    //Передача заказа по TCP

                    //Создаем сокет
                    Socket socket = null;

                    try {
                        socket = new Socket(host, port);
                    } catch (UnknownHostException e) {
                        System.out.println("Неизвестный хост: " + host);
                        System.exit(-1);
                    } catch (IOException e) {
                        System.out.println("Ошибка ввода/вывода при создании сокета " + host
                                + ":" + port);
                        System.exit(-1);
                    }

                    //поток вывода, через который проходят сообщения
                    OutputStream out = null;
                    try {
                        out = socket.getOutputStream();
                    } catch (IOException e) {
                        System.out.println("Невозможно получить поток вывода!");
                        System.exit(-1);
                    }

                    //транслируем объект в поток вывода

                    try(ObjectOutputStream oos = new ObjectOutputStream(new ObjectOutputStream(out))) {
                        oos.writeObject(ord);
                    }
                    catch(Exception ex) {
                        System.out.println(ex.getMessage());
                    }

                }

            }

        }catch(IOException e)
        {
            System.err.println("IOException " + e);
        }
    }
}

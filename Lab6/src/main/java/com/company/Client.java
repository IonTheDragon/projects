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

        int tcp_port = 0;

        int udp_port = 7005;

        String host = "";

        GenerateOrders GenOrd = new GenerateOrders(1);

        Order ord = GenOrd.InitOrder();

        DatagramSocket sock = null;

        try
        {
            sock = new DatagramSocket(udp_port);

            while(true)
            {

                //буфер для получения входящих данных
                byte[] buffer = new byte[65536];
                DatagramPacket reply = new DatagramPacket(buffer, buffer.length);

                //Получаем данные от сервера
                sock.receive(reply);
                byte[] InputData = reply.getData();
                String s = new String(InputData, 0, reply.getLength());

                //Проверяем наличия в сообщении подстроки "ready port"
                String REGEX = "ready port ";
                String INPUT = s;
                Pattern p = Pattern.compile(REGEX);
                Matcher matcher = p.matcher(INPUT);

                if (matcher.lookingAt()) {
                    //при нахождении подстроки выводим адрес, udp и tcp порт
                    System.out.println("Сервер: " + reply.getAddress().getHostAddress() + ", udp порт: " + reply.getPort() + ", получено: " + s);
                    ConnectStatus = 1;
                    host = reply.getAddress().getHostAddress();

                    //убираем пометки из сообщения, оставляя номер tcp порта
                    String REPLACE = "";
                    tcp_port = Integer.parseInt(matcher.replaceAll(REPLACE));
                }
                else if (s.equalsIgnoreCase("")) {
                    //если сообщение пусто - ничего не делать
                }
                else {
                    System.out.println("Получаем данные");
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
                    Thread.sleep(5000);
                    //Передача заказа по TCP
                    System.out.println("Подключаемся по TCP");

                    //Создаем сокет
                    Socket socket = null;

                    try {
                        socket = new Socket(host, tcp_port);
                    } catch (UnknownHostException e) {
                        System.out.println("Неизвестный хост: " + host);
                        System.exit(-1);
                    } catch (IOException e) {
                        System.out.println("Ошибка ввода/вывода при создании сокета " + host
                                + ":" + tcp_port);
                        System.exit(-1);
                    }

                    System.out.println("Инициализация потока");
                    //поток вывода, через который проходят сообщения
                    OutputStream out = null;
                    try {
                        out = socket.getOutputStream();
                    } catch (IOException e) {
                        System.out.println("Невозможно получить поток вывода!");
                        System.exit(-1);
                    }

                    System.out.println("Передача данных");
                    //транслируем объект в поток вывода

                    try(ObjectOutputStream oos = new ObjectOutputStream(new ObjectOutputStream(out))) {
                        oos.writeObject(ord);
                        System.out.println("Передан заказ");
                        ord.OurUser.ReadUser();
                        for (int i = 0; i < ord.PurchasingItemsList.size(); i++) {
                            System.out.println("__________");
                            System.out.println("Идентификатор: "+ord.PurchasingItemsList.get(i).GetId().toString());
                            System.out.println("Тип устройства: "+ord.PurchasingItemsList.get(i).GetDeviceType());
                            System.out.println("Количество: "+ord.PurchasingItemsList.get(i).GetCount());
                            System.out.println("Название: "+ord.PurchasingItemsList.get(i).GetName());
                            System.out.println("Цена: "+ord.PurchasingItemsList.get(i).GetPrice());
                            System.out.println("Изготовитель: "+ord.PurchasingItemsList.get(i).GetCompany());
                            System.out.println("Модель: "+ord.PurchasingItemsList.get(i).GetModel());
                            System.out.println("ОС: "+ord.PurchasingItemsList.get(i).GetOs());
                            if ("Phone".equalsIgnoreCase(ord.PurchasingItemsList.get(i).GetDeviceType())) {
                                System.out.println("Тип корпуса: "+ord.PurchasingItemsList.get(i).GetParam1());
                            }
                            else if ("Smartphone".equalsIgnoreCase(ord.PurchasingItemsList.get(i).GetDeviceType())) {
                                System.out.println("Тип SIM-карты: "+ord.PurchasingItemsList.get(i).GetParam1());
                                System.out.println("Число SIM-карт: "+ord.PurchasingItemsList.get(i).GetParam2());
                            }
                            else if ("Book".equalsIgnoreCase(ord.PurchasingItemsList.get(i).GetDeviceType())) {
                                System.out.println("Процессор: "+ord.PurchasingItemsList.get(i).GetParam1());
                                System.out.println("Разрешение экрана: "+ord.PurchasingItemsList.get(i).GetParam2());
                            }
                        }
                        System.out.println("__________");
                    }
                    catch(Exception ex) {
                        System.out.println(ex.getMessage());
                    }
                    System.out.println("Отключение TCP");

                }

            }

        }catch(IOException e)
        {
            System.err.println("IOException " + e);
        }
    }
}

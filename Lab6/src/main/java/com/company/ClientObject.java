package com.company;

import java.io.IOException;
import java.io.ObjectOutputStream;
import java.io.OutputStream;
import java.net.DatagramPacket;
import java.net.DatagramSocket;
import java.net.Socket;
import java.net.UnknownHostException;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class ClientObject extends Thread{

    private int ReadyToSend;

    private int lind;

    public int tcp_port;

    public int udp_port;

    private String host;

    public GenerateOrders GenOrd;

    public Order ord;

    private DatagramSocket sock = null;

    public ClientObject(int mtcp_port, int mudp_port, GenerateOrders mGenOrd, Order init_ord) {
        tcp_port = mtcp_port;
        udp_port = mudp_port;
        GenOrd = mGenOrd;
        ord = init_ord;
        ReadyToSend = 0;
        lind = 1;
        host = "";
    }

    @Override
    public void run() {
        try {
            sock = new DatagramSocket(udp_port);

            while (true) {

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
                    ReadyToSend = 1;
                    host = reply.getAddress().getHostAddress();

                    //убираем пометки из сообщения, оставляя номер tcp порта
                    String REPLACE = "";
                    tcp_port = Integer.parseInt(matcher.replaceAll(REPLACE));
                } else if (s.equalsIgnoreCase("")) {
                    //если сообщение пусто - ничего не делать
                } else {
                    System.out.println("Получаем данные");
                    System.out.println("________________________");
                    System.out.println(s);
                    System.out.println("________________________");

                    //генерация заказа
                    if (lind > 6) {
                        break;
                    } else {
                        GenOrd.ind = lind;
                        GenOrd.Generate();
                        ord = GenOrd.order;
                        lind++;
                        ReadyToSend = 1;
                    }
                }

                if (ReadyToSend == 1) {
                    try {
                        Thread.sleep(5000);
                    } catch (InterruptedException e) {
                        System.out.println("Работа клиента прервана");
                    }
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

                    try (ObjectOutputStream oos = new ObjectOutputStream(out)) {
                        oos.writeObject(ord);
                        oos.flush();
                        oos.close();
                        System.out.println("Передан заказ пользователя:");
                        ord.OurUser.ReadUser();
                    } catch (Exception ex) {
                        System.out.println(ex.getMessage());
                    }
                    System.out.println("Отключение TCP");
                    ReadyToSend = 0;
                }

            }

        } catch (IOException e) {
            System.err.println("IOException " + e);
        }
    }
}

package org.stonejungle.ivan.Lab7.Controller;

import com.fasterxml.jackson.databind.ObjectMapper;
import com.fasterxml.jackson.databind.module.SimpleModule;
import org.springframework.web.bind.annotation.*;
import org.apache.log4j.*;

import org.stonejungle.ivan.Lab7.Devices.*;
import org.stonejungle.ivan.Lab7.*;
import org.stonejungle.ivan.Lab7.Serializers.*;

import java.io.*;
import java.util.*;

@RestController
public class IndexController {

    Orders allorders = new Orders(1);
    GenerateItems GenItems = new GenerateItems();
    final static Logger logger = Logger.getLogger(IndexController.class);

    @RequestMapping(params = {}, method = RequestMethod.GET)
    public String welcome() {

        logger.info("Загружен проект");
        String answer = "<h2>Лабораторная работа 7</h2>" +
                "<ul><li>При запросе в строке браузера http://localhost:[port]/?command=readall" +
                " возвращаются все заказы в виде JSON.</li>" +
                "<li>При запросе в строке браузера http://localhost:[port]/?command=readById&#38;order_id=[id] " +
                " возвращается обратно заказ с идентификатором [id] в виде JSON.</li>" +
                "<li>При запросе в строке браузера http://localhost:[port]/?command=addToCard&#38;card_id=[id]" +
                " генерируется товар и добавляется в корзину с идентификатором [id].</li>" +
                "<li>При запросе в строке браузера http://localhost:[port]/?command=delById&#38;order_id=[id]" +
                " удаляется заказ с идентификатором [id].</li></ul>";

        try (ObjectOutputStream oos = new ObjectOutputStream(new FileOutputStream("BinOrders.bin"))) {
            oos.writeObject(allorders);
            answer += "<p>Список заказов успешно сохранен</p>";
            logger.info("Список заказов сохранен в BinOrders.bin");
        } catch (Exception ex) {
            answer += "Ошибка записи - " + ex.getMessage();
            logger.error("Ошибка записи - " + ex.getMessage());
        }
        return answer;
    }

    @RequestMapping(params = {"command"}, method = RequestMethod.GET)
    public Orders readAllOrders(@RequestParam(value = "command") String command) {

        Orders returnedorders = new Orders();

        if (command.equalsIgnoreCase("readall")) {
            logger.info("Запрошен список заказов");
            try (ObjectInputStream ois = new ObjectInputStream(new FileInputStream("BinOrders.bin"))) {
                returnedorders = (Orders) ois.readObject();
                logger.info("Список заказов возвращен серверу");
            } catch (Exception ex) {
                logger.error("Ошибка чтения - " + ex.getMessage());
            }
        }

        ObjectMapper mapper = new ObjectMapper();

        SimpleModule module = new SimpleModule();
        module.addSerializer(Phone.class, new PhoneSerializer());
        module.addSerializer(SmartPhone.class, new SmartphoneSerializer());
        module.addSerializer(Book.class, new BookSerializer());
        mapper.registerModule(module);

        return returnedorders;
    }

    @RequestMapping(params = {"command", "order_id"}, method = RequestMethod.GET)
    public Object readOrDelOrdersById(@RequestParam(value = "command") String command,
                                      @RequestParam(value = "order_id") String order_id) {

        Orders OrdersIn = new Orders();
        Object result;

        if (command.equalsIgnoreCase("readById")) {
            logger.info("Запрошен заказ " + order_id);
            try (ObjectInputStream ois = new ObjectInputStream(new FileInputStream("BinOrders.bin"))) {
                OrdersIn = (Orders) ois.readObject();
                try {
                    Order returnedorder = OrdersIn.getOrderById(UUID.fromString(order_id));
                    if (returnedorder.Status.equalsIgnoreCase("Empty Order")) {
                        logger.warn("Заказа с Id " + order_id + " не существует");
                        result = "Заказ не найден";
                    } else {
                        ObjectMapper mapper = new ObjectMapper();

                        SimpleModule module = new SimpleModule();
                        module.addSerializer(Phone.class, new PhoneSerializer());
                        module.addSerializer(SmartPhone.class, new SmartphoneSerializer());
                        module.addSerializer(Book.class, new BookSerializer());
                        mapper.registerModule(module);

                        result = returnedorder;
                    }
                } catch (Exception ex) {
                    logger.error("Ошибка - " + ex.getMessage());
                    result = "Ошибка - " + ex.getMessage();
                }
            } catch (IOException ex) {
                logger.error("Ошибка чтения - " + ex.getMessage());
                result = "Ошибка чтения файла - " + ex.getMessage();
            } catch (ClassNotFoundException ex) {
                logger.error("Ошибка чтения - " + ex.getMessage());
                result = "Ошибка чтения файла - " + ex.getMessage();
            }
        } else if (command.equalsIgnoreCase("delById")) {
            logger.info("Запрошено удаление заказа " + order_id);
            try (ObjectInputStream ois = new ObjectInputStream(new FileInputStream("BinOrders.bin"))) {
                OrdersIn = (Orders) ois.readObject();
                try {
                    Order order = OrdersIn.getOrderById(UUID.fromString(order_id));
                    if (order.Status.equalsIgnoreCase("Empty Order")) {
                        logger.warn("Заказа с Id " + order_id + " не существует");
                        result = "1";
                    } else {
                        OrdersIn.OrdersList.remove(order);
                        logger.info("Заказ " + order_id + " удален");
                        try (ObjectOutputStream oos = new ObjectOutputStream(new FileOutputStream("BinOrders.bin"))) {
                            oos.writeObject(OrdersIn);
                            logger.info("BinOrders.bin успешно обновлен");
                            result = "0";
                        } catch (IOException ex) {
                            logger.error("Ошибка перезаписи - " + ex.getMessage());
                            result = "2";
                        }
                    }
                } catch (Exception ex) {
                    result = "3";
                }
            } catch (IOException ex) {
                logger.error("Ошибка чтения - " + ex.getMessage());
                result = "2";
            } catch (ClassNotFoundException ex) {
                logger.error("Ошибка чтения - " + ex.getMessage());
                result = "2";
            }
        } else result = "3";

        return result;
    }

    @RequestMapping(params = {"command", "card_id"}, method = RequestMethod.GET)
    public String addToCard(@RequestParam(value = "command", required = false) String command,
                            @RequestParam(value = "card_id", required = false) String card_id) {

        String result;

        if (command.equalsIgnoreCase("addToCard")) {
            logger.info("Запрошено добавление нового товара в корзину " + card_id);
            Orders OrdersIn = new Orders();
            result = "No generated items";
            if (GenItems.ind < 7) {
                try {
                    try (ObjectInputStream ois = new ObjectInputStream(new FileInputStream("BinOrders.bin"))) {
                        OrdersIn = (Orders) ois.readObject();
                        logger.info("Список заказов возвращен серверу");
                    } catch (Exception ex) {
                        logger.error("Ошибка чтения - " + ex.getMessage());
                    }
                    result = "Неверный ID корзины";
                    for (int i = 0; i < OrdersIn.OrdersList.size(); i++) {
                        Order c_order = OrdersIn.OrdersList.get(i);
                        if (UUID.fromString(card_id).equals(c_order.OurUser.GetId())) {
                            GenItems.Generate();
                            OrdersIn.OrdersList.get(i).PurchasingItemsList.add(GenItems.dev);
                            result = GenItems.id;
                            break;
                        }
                    }
                    try (ObjectOutputStream oos = new ObjectOutputStream(new FileOutputStream("BinOrders.bin"))) {
                        oos.writeObject(OrdersIn);
                        logger.info("BinOrders.bin успешно обновлен");
                    } catch (IOException ex) {
                        logger.error("Ошибка перезаписи - " + ex.getMessage());
                    }
                    logger.info("Товар с Id " + result + " добавлен в корзину " + card_id);
                } catch (Exception ex) {
                    result = ex.getMessage();
                    logger.error(ex.getMessage());
                }
            }
        } else {
            result = "Wrong command";
        }
        return result;
    }
}

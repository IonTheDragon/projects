package org.stonejungle.ivan.Lab7;

import java.io.Serializable;
import java.util.Date;
import java.util.*;

import org.stonejungle.ivan.Lab7.Devices.*;

public class Orders implements Serializable {

    public List<Order> OrdersList = new LinkedList<>();

    public void Buy(Order m_order) {
        this.OrdersList.add(m_order);
    }

    public void show() {

        for (int i = 0; i < OrdersList.size(); i++) {
            System.out.println("________________________");
            Order m_order = OrdersList.get(i);
            List<Device> m_PurchasingItemsList = m_order.PurchasingItemsList;
            for (int j = 0; j < m_PurchasingItemsList.size(); j++) {

                System.out.println("Идентификатор: "+m_PurchasingItemsList.get(j).GetId().toString());
                System.out.println("Тип устройства: "+m_PurchasingItemsList.get(j).GetDeviceType());
                System.out.println("Количество: "+m_PurchasingItemsList.get(j).GetCount());
                System.out.println("Название: "+m_PurchasingItemsList.get(j).GetName());
                System.out.println("Цена: "+m_PurchasingItemsList.get(j).GetPrice());
                System.out.println("Изготовитель: "+m_PurchasingItemsList.get(j).GetCompany());
                System.out.println("Модель: "+m_PurchasingItemsList.get(j).GetModel());
                System.out.println("ОС: "+m_PurchasingItemsList.get(j).GetOs());
                if ("Phone".equalsIgnoreCase(m_PurchasingItemsList.get(j).GetDeviceType())) {
                    System.out.println("Тип корпуса: "+m_PurchasingItemsList.get(j).GetParam1());
                }
                else if ("Smartphone".equalsIgnoreCase(m_PurchasingItemsList.get(j).GetDeviceType())) {
                    System.out.println("Тип SIM-карты: "+m_PurchasingItemsList.get(j).GetParam1());
                    System.out.println("Число SIM-карт: "+m_PurchasingItemsList.get(j).GetParam2());
                }
                else if ("Book".equalsIgnoreCase(m_PurchasingItemsList.get(j).GetDeviceType())) {
                    System.out.println("Процессор: "+m_PurchasingItemsList.get(j).GetParam1());
                    System.out.println("Разрешение экрана: "+m_PurchasingItemsList.get(j).GetParam2());
                }

                System.out.println("________________________");

            }
            System.out.println("Заказчик");
            User user = m_order.OurUser;
            user.ReadUser();
            System.out.println("________________________");
            System.out.println("Статус");
            System.out.println(m_order.Status);
            System.out.println("________________________");
            System.out.println("Время заказа");
            System.out.println(m_order.CreationTime);
            System.out.println("________________________");
        }
    }

    public Order getOrderById(UUID m_id) {

        Order m_order = new Order();

        for (int i = 0; i < OrdersList.size(); i++) {
            Order c_order = OrdersList.get(i);
            if (m_id.equals(c_order.OurUser.GetId())) {
                m_order = OrdersList.get(i);
                break;
            }
        }
        return m_order;
    }

    public Orders(int init) {
        if (init == 1) {
            Credentials customers = new Credentials();

            customers.AddUser("Ashot", "Galustyan", "Vaganych", "armen@mail.am");
            customers.AddUser("Stas", "Hrenov", "Petrovich", "hrenoff@mail.ru");
            customers.AddUser("Katya", "Iwanova", "Petrovna", "katya@gmail.com");
            customers.AddUser("Ivan", "Voznyuk", "Vyacheslavovich", "ivan@stonejungle.org");
            customers.AddUser("Ivan", "Hromov", "Stepanovich", "СЕКРЕТНО");
            customers.AddUser("Janna", "Rasputin", "Michailovna", "janna@gmail.com");
            customers.AddUser("Ramzan", "Vazgenka", "Michailovna", "ramzanzanzan@ya.ru");

            ShoppingCart Cart1 = new ShoppingCart<Device>();
            ShoppingCart Cart2 = new ShoppingCart<Device>();
            ShoppingCart Cart3 = new ShoppingCart<Device>();
            ShoppingCart Cart4 = new ShoppingCart<Device>();
            ShoppingCart Cart5 = new ShoppingCart<Device>();
            ShoppingCart Cart6 = new ShoppingCart<Device>();

            Phone ph1 = new Phone("2", "Хсяомя", "3500", "Джамшут дистрибутив", "Хсяомя Хэ", "Ведроид 2.0", "Классический", " ");
            SmartPhone sph1 = new SmartPhone("1", "Унитазофон", "25000", "Индус-прошивка", "Унитазофон 2018", "Шишдовз визда", "Обычная", "2");
            Book bk1 = new Book("1", "ПакетБука", "33000", "Гараж Васяна", "Планшет 3000 элитный", "Макось с таблэткой", "Пенек", "900х1200");
            Phone ph2 = new Phone("2", "Бревнофон", "300", "Икея", "Бревнофон 3000", "Бревноид 1.1", "Классический", "резерв");
            SmartPhone sph2 = new SmartPhone("1", "Унитазофон", "24000", "Индус-прошивка", "Унитазофон 2017", "Шишдовз визда", "Обычная", "1");
            Book bk2 = new Book("1", "Доска деревянная", "50", "Димон инк", "Доска 2018", "Скоро будет", "Доска на пеньке", "900х1200");
            Phone ph3 = new Phone("3", "Nokia", "12000", "Nokia", "Nokia 4", "Android", "Классический", "резерв");
            Book bk3 = new Book("2", "NovaBook", "55000", "Green Gecko", "Nova X", "GeckOS", "CycluraIntegral", "900х1200");
            Phone ph4 = new Phone("5", "СЕКРЕТНО", "СЕКРЕТНО", "СЕКРЕТНО", "СЕКРЕТНО", "СЕКРЕТНО", "СЕКРЕТНО", "резерв");
            Book bk4 = new Book("5", "СЕКРЕТНО", "СЕКРЕТНО", "СЕКРЕТНО", "СЕКРЕТНО", "СЕКРЕТНО", "СЕКРЕТНО", "СЕКРЕТНО");
            Phone ph5 = new Phone("1", "МОНОЛИТ", "350000", "Циклура", "УДАЛЕНО", "УДАЛЕНО", "Классический", "резерв");
            SmartPhone sph5 = new SmartPhone("1", "Артемида", "600000", "УДАЛЕНО", "Артемида УДАЛЕНО", "УДАЛЕНО", "Обычная", "УДАЛЕНО");
            Book bk5 = new Book("1", "Прототип 33460", "500000", "Циклура", "33460 2018", "СЕКРЕТНО", "СЕКРЕТНО", "4000х4000");

            Cart1.add(ph1);
            Cart1.add(sph1);
            Cart1.add(bk1);
            this.OrdersList.add(new Order(Cart1, customers, 0));

            Cart2.add(ph2);
            Cart2.add(sph2);
            Cart2.add(bk2);
            this.OrdersList.add(new Order(Cart2, customers, 1));

            Cart3.add(ph3);
            Cart3.add(bk3);
            this.OrdersList.add(new Order(Cart3, customers, 2));

            Cart4.add(ph4);
            Cart4.add(bk4);
            this.OrdersList.add(new Order(Cart4, customers, 3));

            Cart5.add(ph5);
            Cart5.add(sph5);
            Cart5.add(bk5);
            this.OrdersList.add(new Order(Cart5, customers, 4));

            Cart6.add(ph3);
            Cart6.add(sph1);
            Cart6.add(bk2);
            this.OrdersList.add(new Order(Cart5, customers, 5));
        }
    }
    public Orders() {

    }
}

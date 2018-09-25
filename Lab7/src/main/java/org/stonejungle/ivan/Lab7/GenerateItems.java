package org.stonejungle.ivan.Lab7;

import org.stonejungle.ivan.Lab7.Devices.Book;
import org.stonejungle.ivan.Lab7.Devices.Device;
import org.stonejungle.ivan.Lab7.Devices.Phone;
import org.stonejungle.ivan.Lab7.Devices.SmartPhone;

import java.util.List;

public class GenerateItems<T extends Device> {

        public int ind;
        public String id;
        public T dev;

        Book bk1 = new Book("2","NovaBook","55000","Green Gecko","Nova X","GeckOS","CycluraIntegral","900х1200");
        Phone ph2 = new Phone("5","YobaPhone","60000","YobaStudio","Yoba228","Yobaos","RASCRIVUSHKA","резерв");
        Book bk3 = new Book("5","Note17","СЕКРЕТНО","СЕКРЕТНО","СЕКРЕТНО","СЕКРЕТНО","СЕКРЕТНО","СЕКРЕТНО");
        Phone ph4 = new Phone("1","Nokea","1700","Циклура","Nokea18","OS priorat Cyclura HumanEdition","Классический","резерв");
        SmartPhone sph5 = new SmartPhone("1","Артемида","600000","УДАЛЕНО","Артемида УДАЛЕНО","УДАЛЕНО","Обычная","УДАЛЕНО");
        Book bk6 = new Book("1","Прототип 33548","100000","Циклура","33548 2018","priorat Cyclura prototype 634","Cubite prototype 634548332","modifying");

        public GenerateItems() {
            this.ind = 1;
        }

        public void Generate() {
            if (ind == 1) {
                dev = (T)bk1;
                id = bk1.GetId().toString();
            }
            else if (ind == 2) {
                dev = (T)ph2;
                id = ph2.GetId().toString();
            }
            else if (ind == 3) {
                dev = (T)bk3;
                id = bk3.GetId().toString();
            }
            else if (ind == 4) {
                dev = (T)ph4;
                id = ph4.GetId().toString();
            }
            else if (ind == 5) {
                dev = (T)sph5;
                id = sph5.GetId().toString();
            }
            else if (ind == 6) {
                dev = (T)bk6;
                id = bk6.GetId().toString();
            }
            ind ++;
        }
}



package com.company;

import java.util.*;
import com.company.Devices.*;

public class ShoppingCart<T extends Device> {
    ArrayList<T> ShoppingCartList = new ArrayList<>();

    public void add(T m_item) {

        ShoppingCartList.add(m_item);
    }

    public void delete(T m_item) {
        ArrayList<T> deleteCandidates = new ArrayList<>();

        // Pass 1 - collect delete candidates
        for (T select_item : ShoppingCartList) {
            if (select_item==m_item) {
                deleteCandidates.add(select_item);
            }
        }

        // Pass 2 - delete
        for (T deleteCandidate : deleteCandidates) {
            ShoppingCartList.remove(deleteCandidate);
        }
    }

    public void show(List<T> m_ShoppingCartList) {

        System.out.println("________________________");
        for (int i = 0; i < m_ShoppingCartList.size(); i++) {
            System.out.println("Идентификатор: "+m_ShoppingCartList.get(i).GetId().toString());
            System.out.println("Тип устройства: "+m_ShoppingCartList.get(i).GetDeviceType());
            System.out.println("Количество: "+m_ShoppingCartList.get(i).GetCount());
            System.out.println("Название: "+m_ShoppingCartList.get(i).GetName());
            System.out.println("Цена: "+m_ShoppingCartList.get(i).GetPrice());
            System.out.println("Изготовитель: "+m_ShoppingCartList.get(i).GetCompany());
            System.out.println("Модель: "+m_ShoppingCartList.get(i).GetModel());
            System.out.println("ОС: "+m_ShoppingCartList.get(i).GetOs());
            if ("Phone".equalsIgnoreCase(m_ShoppingCartList.get(i).GetDeviceType())) {
                System.out.println("Тип корпуса: "+m_ShoppingCartList.get(i).GetParam1());
            }
            else if ("Smartphone".equalsIgnoreCase(m_ShoppingCartList.get(i).GetDeviceType())) {
                System.out.println("Тип SIM-карты: "+m_ShoppingCartList.get(i).GetParam1());
                System.out.println("Число SIM-карт: "+m_ShoppingCartList.get(i).GetParam2());
            }
            else if ("Book".equalsIgnoreCase(m_ShoppingCartList.get(i).GetDeviceType())) {
                System.out.println("Процессор: "+m_ShoppingCartList.get(i).GetParam1());
                System.out.println("Разрешение экрана: "+m_ShoppingCartList.get(i).GetParam2());
            }
            System.out.println("________________________");
        }
    }

    public UUID readId(List<T> m_ShoppingCartList, int i) {
        return m_ShoppingCartList.get(i).GetId();
    }

    public void search(List<T> m_ShoppingCartList, UUID m_id) {
        int is_found = 0;
        for (int i = 0; i < m_ShoppingCartList.size(); i++) {

            if (m_id==m_ShoppingCartList.get(i).GetId()) {
                System.out.println("________________________");
                System.out.println("Товар найден");

                System.out.println("Идентификатор: "+m_ShoppingCartList.get(i).GetId().toString());
                System.out.println("Тип устройства: "+m_ShoppingCartList.get(i).GetDeviceType());
                System.out.println("Количество: "+m_ShoppingCartList.get(i).GetCount());
                System.out.println("Название: "+m_ShoppingCartList.get(i).GetName());
                System.out.println("Цена: "+m_ShoppingCartList.get(i).GetPrice());
                System.out.println("Изготовитель: "+m_ShoppingCartList.get(i).GetCompany());
                System.out.println("Модель: "+m_ShoppingCartList.get(i).GetModel());
                System.out.println("ОС: "+m_ShoppingCartList.get(i).GetOs());
                if ("Phone".equalsIgnoreCase(m_ShoppingCartList.get(i).GetDeviceType())) {
                    System.out.println("Тип корпуса: "+m_ShoppingCartList.get(i).GetParam1());
                }
                else if ("Smartphone".equalsIgnoreCase(m_ShoppingCartList.get(i).GetDeviceType())) {
                    System.out.println("Тип SIM-карты: "+m_ShoppingCartList.get(i).GetParam1());
                    System.out.println("Число SIM-карт: "+m_ShoppingCartList.get(i).GetParam2());
                }
                else if ("Book".equalsIgnoreCase(m_ShoppingCartList.get(i).GetDeviceType())) {
                    System.out.println("Процессор: "+m_ShoppingCartList.get(i).GetParam1());
                    System.out.println("Разрешение экрана: "+m_ShoppingCartList.get(i).GetParam2());
                }

                System.out.println("________________________");
                is_found = 1;
                break;
            }
        }
        if (is_found==0) {
            System.out.println("Товар не найден");
            System.out.println("________________________");
        }
    }
}

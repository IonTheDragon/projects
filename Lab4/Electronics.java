public class Electronics {
	public static void main (String args[]) {
		if ("Phone".equalsIgnoreCase(args[0])) {
			System.out.println("Объект: телефон");
			Phone ph = new Phone();
				ph.create();
			if ("Sample".equalsIgnoreCase(args[1])) {
				System.out.println("Вывод изначальных значений");
			}
			else if ("Manual".equalsIgnoreCase(args[1])) {
				ph.update(args[2],args[3],args[4],args[5],args[6],args[7],args[8]);
			}	
			else {
				System.out.println("Неверно выбран метод заполнения данных. Данные установлены по умолчанию");
			}
			ph.read();
			ph.delete();
		}
		else if ("Smartphone".equalsIgnoreCase(args[0])) {
			System.out.println("Объект: смартфон");
			SmartPhone smp = new SmartPhone();
				smp.create();
			if ("Sample".equalsIgnoreCase(args[1])) {
				System.out.println("Вывод изначальных значений");
			}
			else if ("Manual".equalsIgnoreCase(args[1])) {
				smp.update(args[2],args[3],args[4],args[5],args[6],args[7],args[8]);
			}	
			else {
				System.out.println("Неверно выбран метод заполнения данных. Данные установлены по умолчанию");
			}
			smp.read();
			smp.delete();						
		}
		else if ("Book".equalsIgnoreCase(args[0])) {
			System.out.println("Объект: планшет");
			Book bk = new Book();
				bk.create();
			if ("Sample".equalsIgnoreCase(args[1])) {
				System.out.println("Вывод изначальных значений");
			}
			else if ("Manual".equalsIgnoreCase(args[1])) {
				bk.update(args[2],args[3],args[4],args[5],args[6],args[7],args[8]);
			}	
			else {
				System.out.println("Неверно выбран метод заполнения данных. Данные установлены по умолчанию");
			}
			bk.read();
			bk.delete();		
		}
		else {
			System.out.println("Неверно выбран тип устройства");
		}
	}
}

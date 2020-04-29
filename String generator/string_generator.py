import random
import string

step_1 = 1
data_length = 0
while step_1:
    print('Введите число')
    data_length = input()    
    try:
        data_length = int(data_length)
        if data_length <= 0:
            print('Необходимо ввести положительное число')
        else:
            step_1 = 0;
    except ValueError:
        print('Необходимо ввести целое число')

data = ''.join(random.SystemRandom().choice(string.ascii_uppercase + string.digits) for _ in range(data_length))
print(data)

step_2 = 1
replace_1 = 0
while step_2:
    print('Введите символ для замены букв')
    replace_1 = input()

    if len(replace_1) == 1:        
        #if replace_1 in string.digits:
        #    print('Необходимо ввести нечисловой символ')
        #else:
            step_2 = 0
    else:
        print('Необходимо ввести один символ')

data_array = list(data)
i = 0
num_1 = 0
while i < len(data_array):
    if (data_array[i] in string.ascii_uppercase):
        data_array[i] = replace_1
        num_1 += 1
    i += 1
    
data = "".join(data_array)

step_3 = 1
replace_2 = 0
while step_3:
    print('Введите второй символ для замены цифр')
    replace_2 = input()

    if len(replace_2) == 1:        
        step_3 = 0
    else:
        print('Необходимо ввести один символ')

data_array = list(data)
i = 0
num_2 = 0
while i < len(data_array):
    if (data_array[i] in string.digits):
        data_array[i] = replace_2
        num_2 += 1
    i += 1
    
data = "".join(data_array)

print(data)
print('Число повторов первого символа: '+str(num_1))
print('Число повторов второго символа: '+str(num_2))

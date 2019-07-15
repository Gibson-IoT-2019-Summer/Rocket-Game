# author Gibson Jang
# date 07-15-2019
# email purespiritman@gmail.com

old_fuel = 100
thrusters = 0
gravity = -10
old_position = 100
old_velocity = 0
new_fuel = old_fuel - thrusters

i = 1

while new_fuel !=0:
    if i == 1:
        print "P: ",(old_position), "V: ",(old_velocity), "F: ",(old_fuel)
        thrusters = int(raw_input("Set thrusters(0-20): "))
        if thrusters < 0:
            thrusters = 0
            print "No thrusters(0)!"
        if thrusters >= 20:
            thrusters = 20
            print "Thrusters at max(20)!"
        i =0
        new_fuel = old_fuel - thrusters
        accelation = gravity + thrusters
        new_position = old_position + old_velocity + accelation * 0.5
        new_velocity = old_velocity + accelation
        old_position = new_position
        old_velocity = new_velocity
        old_fuel = new_fuel
    elif i == 0:
        print "P: ", (int(new_position)), "V: ", (new_velocity), "F: ", (new_fuel)
        thrusters = int(raw_input("Set thrusters(0-20): "))
        if thrusters < 0:
            thrusters = 0
            print "No thrusters(0)!"
        if thrusters >= 20:
            thrusters = 20
            print "Thrusters at max(20)!"
        new_fuel = old_fuel - thrusters
        if new_fuel < 0:
            print "Out of fuel! Thrusters at {0}".format(old_fuel)
            new_fuel =0
            thrusters = old_fuel
        accelation = gravity + thrusters
        new_position = old_position + old_velocity + accelation * 0.5
        new_velocity = old_velocity + accelation
        old_position = new_position
        old_velocity = new_velocity
        old_fuel = new_fuel
        if new_position <= 0 and new_velocity > -3 and 3 > new_velocity :
            new_position = 0
            print "P: ", (int(new_position)), "V: ", (new_velocity), "F: ", (new_fuel)
            print "Landing successful"
            break

while new_position >= 0 and new_fuel ==0:
    thrusters =0
    print "P: ", (int(new_position)), "V: ", (new_velocity), "F: ", (new_fuel)
    print "No fuel -- rocket is in free-fall!"
    new_fuel = old_fuel - thrusters
    accelation = gravity + thrusters
    new_position = old_position + old_velocity + accelation * 0.5
    new_velocity = old_velocity + accelation
    old_position = new_position
    old_velocity = new_velocity
    old_fuel = new_fuel
    if new_position <0:
        new_position =0
        print "P: ", (int(new_position)), "V: ", (new_velocity), "F: ", (new_fuel)
        print "Rocket crashed! Velocity was {0}".format(new_velocity),"m/s"
        break


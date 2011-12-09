function mag = __bodeMag(sys,omega)
jomega=omega*1i;
mag = abs(polyval(sys.num,jomega))/abs(polyval(sys.den,jomega));

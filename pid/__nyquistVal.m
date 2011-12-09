function [re im] = __nyquistVal(sys,delay,omega)
jomega=omega*1i;
z=polyval(sys.num,jomega)/polyval(sys.den,jomega);
z=z*exp(-delay*jomega);
re=real(z);
im=imag(z);

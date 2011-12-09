function phase = __bodePhase(sys,delay,omega)
jomega=1i*omega;
phase=arg( polyval(sys.num,jomega)/polyval(sys.den,jomega))-delay;

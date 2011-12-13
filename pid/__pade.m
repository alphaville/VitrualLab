function [E F] = __pade(delay)
if delay^2<1E-5
E=1;
F=1;
else
 E = [1/840 2/105 1/7 4/7 1]*delay;
 F = [-1/210 1/14 -3/7 1]*delay;
end
end
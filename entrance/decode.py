key = 6258945

def mod_inverse(a, m):
    m0 = m
    x0, x1 = 0, 1

    if m == 1:
        return 0

    while a > 1:
        q = a // m
        a, m = m, a % m
        x0, x1 = x1 - q * x0, x0

    return x1 + m0 if x1 < 0 else x1


def inverse_transform(y, key, mul=73, mod=9973):
    after_xor = y ^ key
    inv_mul = mod_inverse(mul, mod)
    return (after_xor * inv_mul) % mod

newNumber = inverse_transform(int(input("Bitte Zahl eingeben:")), key, mul=73, mod=9973)
print(newNumber)
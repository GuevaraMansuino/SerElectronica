<?php

/**
 * Sinónimos de búsqueda para el catálogo de electrónica
 * 
 * Define términos alternativos que se buscarán junto con el término original.
 * Esto permite que búsquedas como "repe" encuentren "Repetidor WiFi", "Extensor", etc.
 */

return [
    // Repetidores y extensores de señal
    'repe' => ['repetidor', 'repetidor wifi', 'extensor', 'extensor wifi', 'amplificador', 'amplificador wifi', 'booster', 'mesh', 'wifi mesh'],
    'repetidor' => ['repe', 'repetidor wifi', 'extensor', 'extensor wifi', 'amplificador', 'amplificador wifi'],
    'extensor' => ['repe', 'repetidor', 'repetidor wifi', 'amplificador', 'booster', 'wifi'],
    'amplificador' => ['repe', 'repetidor', 'extensor', 'booster', 'signal'],
    'booster' => ['amplificador', 'extensor', 'repetidor', 'signal'],
    'mesh' => ['wifi mesh', 'sistema mesh', 'red mesh', 'repetidor mesh', 'eero', 'tp-link mesh', 'decoplus'],
    
    // WiFi y redes
    'wifi' => ['wi-fi', 'inalambrico', 'inalámbrico', 'wireless', 'red wifi'],
    'router' => ['enrutador', 'router wifi', 'router inalambrico', 'modem', 'router 4g', 'router 5g', 'router ax'],
    'modem' => ['modem router', 'router', 'ont', 'fibra', 'adsl'],
    'switch' => ['conmutador', 'switch ethernet', 'switch gigabit', 'switch managed', 'switch unmanaged'],
    'access point' => ['punto de acceso', 'ap', 'access point wifi', 'ubiquiti', 'tp-link ap'],
    'cable ethernet' => ['cable red', 'cable rj45', 'utp', 'ftp', 'cable lan', 'cable de red'],
    'fibra' => ['fibra optica', 'fibra óptica', 'cable fibra', 'patch cord fibra', 'lc', 'sc', 'fc'],
    
    // Cargadores y baterías
    'cargador' => ['carga', 'cargador rapido', 'cargador usb', 'cargador cell', 'power delivery', 'qc', 'quick charge'],
    'bateria' => ['batería', 'pila', 'powerbank', 'cargador portatil', 'cargador portátil', 'auxiliar'],
    'powerbank' => ['bateria externa', 'batería externa', 'cargador portatil', 'auxiliar', 'power bank'],
    'pila' => ['batería', 'pilaaa', 'baterias', 'pilas', 'recargable', 'aa', 'aaa', '18650'],
    
    // Audio
    'auricular' => ['auriculares', 'headphone', 'headphones', 'audifonos', 'audífonos', 'headset', 'diadema'],
    'parlante' => ['parlantes', 'bocina', 'bocinas', 'speaker', 'speakers', 'altavoz', 'altoparlante'],
    'microfono' => ['micrófono', 'microfono', 'mic', 'mic pod', 'microfono usb', 'microfono inalambrico'],
    'soundbar' => ['barra de sonido', 'home theater', 'teatro en casa', 'audio'],
    
    // Cables y conectores
    'cable hdmi' => ['hdmi', 'cable 4k', 'cable 8k', 'cable audiovisual', 'cable tv'],
    'cable usb' => ['usb', 'cable tipo c', 'cable lightning', 'cable micro usb', 'usb-c', 'usb tipo c'],
    'cable' => ['cableado', 'cordón', 'flex', 'cable de datos', 'cable carga'],
    'adaptador' => ['adapter', 'convertidor', 'dongle', 'acople', 'caja', 'borneras'],
    
    // Iluminación
    'led' => ['luz led', 'lampara led', 'bombilla led', 'ampolleta led', 'foco led'],
    'luz' => ['iluminación', 'iluminacion', 'luces', 'lamp', 'lámpara', 'bombilla'],
    'tira led' => ['tira led rgb', 'tira luminosa', 'neon led', 'luces led'],
    
    // Telefonía
    'celular' => ['teléfono', 'telefono', 'smartphone', 'movil', 'móvil', 'iphone', 'samsung', 'xiaomi', 'motorola'],
    'sim' => ['simcard', 'sim card', 'chip', 'nano sim', 'micro sim', 'esim'],
    'fundas' => ['funda', 'case', 'protector', 'cover', 'carcasa', 'skin'],
    'vidrio templado' => ['vidrio', 'templado', 'protector pantalla', 'glass', 'templado', '南极'],
    
    // Computación
    'computadora' => ['computador', 'pc', 'computadora de escritorio', 'desktop', 'torre'],
    'notebook' => ['laptop', 'portatil', 'portátil', 'ultrabook', 'macbook'],
    'tablet' => ['tab', 'ipad', 'tablets', 'pizarra', 'surface'],
    'mouse' => ['ratón', 'raton', 'input', 'mouser', 'trackball', 'touchpad'],
    'teclado' => ['keyboard', 'teclado mecanico', 'teclado gamer', 'mecanico', 'membrane'],
    'monitor' => ['pantalla', 'display', 'screen', 'monitor hdmi', 'monitor 4k'],
    'disco' => ['dd', 'hdd', 'ssd', 'disco rigido', 'disco solido', 'nvme', 'm.2'],
    'memoria ram' => ['ram', 'memoria', 'ddr4', 'ddr5', 'so-dimm', 'udimm'],
    'fuente' => ['fuente poder', 'psu', 'fuente alimentacion', 'fuente de poder'],
    'gabinete' => ['case', 'chasis', 'torre', 'caja', 'mid tower', 'full tower'],
    'ventilador' => ['fan', 'cooler', 'cooler cpu', 'fan rgb', 'ventilador rgb'],
    'placa madre' => ['motherboard', 'placa base', 'board', 'placa', 'mainboard', 'z390', 'b550', 'a520'],
    'procesador' => ['cpu', 'chip', 'micro', 'intel', 'amd', 'ryzen', 'core i7', 'i9'],
    'tarjeta grafica' => ['gpu', '显卡', 'grafica', 'graphics card', 'rtx', 'gtx', 'radeon', 'nvidia', 'amd'],
    
    // Herramientas
    'soldador' => ['soldadura', 'soldadora', 'cautin', ' cautin', 'iron', ' soldering iron'],
    'multimetro' => ['multímetro', 'tester', 'medidor', 'voltmetro', 'amperimetro'],
    'fuente variable' => ['fuente laboratorio', 'power supply', ' fuente ajustabe', 'variable'],
    'osciloscopio' => ['oscilloscope', 'scope', 'medidor frecuencia'],
    'crimpadora' => ['crimpador', 'pinza crimp', 'cable tool'],
    'pelacables' => ['stripper', 'cortacables', 'wire stripper'],
    
    // Seguridad
    'camara' => ['cámara', 'cam', 'cctv', 'seguridad', 'vigilancia', 'ip camera', 'wifi camera'],
    'dvr' => ['nvr', 'grabador', 'dvr seguridad', 'grabadora'],
    'alarma' => ['sensor', 'detector', 'sistema alarma', 'seguridad hogar'],
    'cerradura' => ['cerrojo', 'lock', 'smart lock', 'cerradura inteligente', 'biometrica'],
    
    // Refrigeración
    'ventilador' => ['fan', 'cooler', 'cooling', 'cooler fan', 'rgb fan'],
    'cooler' => ['cooler cpu', 'cooler procesador', 'ventilador cpu', 'disipador'],
    'pasta termica' => ['pasta térmica', 'thermal paste', 'thermal compound', 'grease'],
    
    // Varios
    'tester' => ['multimetro', 'medidor', 'instrumento', 'digital', 'analogico'],
    'raspberry' => ['raspberry pi', 'rpi', ' SBC', 'mini pc', 'orange pi', 'banana pi'],
    'arduino' => ['microcontrolador', 'atmega', 'esp32', 'esp8266', 'nodemcu', 'microcontroller'],
    'esp32' => ['esp8266', 'wifi', 'bluetooth', 'iot', 'esp32cam', 'nodemcu'],
    'bombilla' => ['bombilla led', 'lamp', 'lampara', 'ampolleta', 'foco'],
    'interruptor' => ['switch', 'conmutador', 'llave', 'boton', 'pulsador'],
    'toma' => ['enchufe', 'socket', 'tomacorriente', 'power', 'corriente'],
];

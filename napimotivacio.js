import { useState, useEffect } from "react";
import { Card, CardContent } from "@/components/ui/card";
import { Button } from "@/components/ui/button";

const messages = [
    "Ne hagyd, hogy a fáradtság megállítson! Minden egyes ismétlés közelebb visz a céljaidhoz. 💪",
    "A siker nem véletlen. Minden edzés egy új lépés a legjobb verziód felé. 🏋️‍♂️",
    "Ma is erősebb vagy, mint tegnap! Ne hagyd, hogy bármi elvonja a figyelmedet a céljaidról. 🔥",
    "A fájdalom csak ideiglenes, de a büszkeség örökké tart. Tarts ki! 💯",
    "Minden egyes csepp izzadság egy lépés a változás felé. Ne állj meg! 🚀",
    "Amikor úgy érzed, hogy nem bírod tovább, tudd, hogy akkor vagy a legközelebb a sikerhez! 🌟",
    "Ne csak álmodj a változásról, dolgozz érte! Az erő benned van. 🔨",
    "A kemikáliekkel teli világban az igazi erő a kitartásban rejlik. Minden edzés hozzátesz a legjobb verzióhoz! 💥",
    "A mai edzés alapja a holnapi sikered. Ne hagyd ki! 🌱",
    "Hozd ki a legtöbbet magadból – minden perc, minden ismétlés számít! ⏳",
    "Minden egyes edzés új erőt ad. Tudd, hogy a határaidat most léped át! 🔝",
    "Ha fáj, az jó jel! Az igazi fejlődés ott kezdődik, ahol a komfortzónád véget ér. 💪",
    "Ne add fel! Minden egyes perc közelebb hoz a céljaidhoz. ⏳",
    "A kitartásod a legnagyobb erő! A változás nem jön könnyen, de megéri. ⚡",
    "A nehézségek csak megerősítenek. Még akkor is, ha úgy tűnik, hogy nem megy tovább. 🔥",
    "Minden edzés lehetőséget ad arra, hogy erősebb legyél. Légy büszke arra, hogy megteszed! 🏆",
    "Az edzés a legjobb befektetés, amit magadba tehetsz. Ne hagyd ki! 💸",
    "Ne várj a tökéletes pillanatra. A változás most kezdődik! ⏰",
    "A határaid nem ott vannak, ahol most érzékeled őket. Tedd próbára őket! 🚀",
    "Ne számold az ismétléseket, hanem éld meg őket! Minden egyes mozdulat hozzájárul a célhoz. 🔄",
    "A szorgalom és a kitartás meghozza gyümölcsét. Ma is egy lépéssel közelebb kerültél! 🌱",
    "Ne a tökéletességre törekedj, hanem a fejlődésre. Minden nap új lehetőség. 🏅",
    "A fájdalom ideiglenes, de az eredmények örökre megmaradnak. 🔥",
    "A mai edzés a holnapi erőd. Ne állj meg most! 💥",
    "Az igazi erő nem csak a súlyokban, hanem a fejedben is rejlik. 🧠",
    "Minden edzés egy új esély a növekedésre. Ne hagyd ki a lehetőséget! 📈",
    "A legnagyobb versenyt nem másokkal vívod, hanem saját magaddal. 🏁",
    "Amikor meg akarsz állni, emlékezz, miért kezdted el! 💡",
    "Az eredmény nem véletlen. Az eredmény kemikális összetevője a kemény munka! 💪",
    "Még egy ismétlés! Még egy szett! Még egy lépés a siker felé! 🎯",
    "A cél nem az, hogy erősebb legyél, hanem hogy a legjobb verziót hozd ki magadból. 🏋️‍♀️",
    "A változás nem az edzés során történik, hanem azután, amikor már úgy érzed, nem bírod tovább. 💥",
    "Tudd, hogy a legnagyobb győzelmek a legnehezebb pillanatokból születnek. 🏆",
    "A sikerhez vezető út nem könnyű, de megéri! Tartsd a fókuszt és sose állj meg! ✨",
    "A legnehezebb napok építenek a legerősebb emberekké. Tarts ki! 🔥"
];

const getDailyMessage = () => {
    const index = new Date().getDate() % messages.length;
    return messages[index];
};

export default function DailyMotivation() {
    const [message, setMessage] = useState(getDailyMessage);

    useEffect(() => {
        const interval = setInterval(() => {
            setMessage(getDailyMessage);
        }, 24 * 60 * 60 * 1000);
        return () => clearInterval(interval);
    }, []);

    return (
        <Card className="w-full max-w-md mx-auto mt-4 p-4 text-center">
            <CardContent>
                <h2 className="text-lg font-semibold">Napi Motiváció</h2>
                <p className="mt-2 text-gray-700">{message}</p>
                <Button className="mt-4" onClick={() => setMessage(getDailyMessage())}>
                    Frissítés
                </Button>
            </CardContent>
        </Card>
    );
}

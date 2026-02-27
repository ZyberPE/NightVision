<?php

namespace NightVision;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\entity\effect\EffectInstance;

class Main extends PluginBase {

    public function onEnable(): void {
        $this->getLogger()->info("NightVision plugin enabled!");
    }

    public function onDisable(): void {
        $this->getLogger()->info("NightVision plugin disabled!");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {

        if (!$sender instanceof Player) {
            $sender->sendMessage("§cThis command can only be used in-game.");
            return true;
        }

        if (!$sender->hasPermission("nv.use")) {
            $sender->sendMessage("§cYou do not have permission to use this command.");
            return true;
        }

        if (!isset($args[0])) {
            $sender->sendMessage("§eUsage: §a/" . $label . " on §eor §a/" . $label . " off");
            return true;
        }

        switch (strtolower($args[0])) {

            case "on":
                $effect = new EffectInstance(
                    VanillaEffects::NIGHT_VISION(),
                    999999999, // very long duration (in ticks)
                    0,
                    false
                );
                $sender->getEffects()->add($effect);
                $sender->sendMessage("§aNight vision has been added.");
                break;

            case "off":
                $sender->getEffects()->remove(VanillaEffects::NIGHT_VISION());
                $sender->sendMessage("§cNight vision has been removed.");
                break;

            default:
                $sender->sendMessage("§eUsage: §a/" . $label . " on §eor §a/" . $label . " off");
                break;
        }

        return true;
    }
}

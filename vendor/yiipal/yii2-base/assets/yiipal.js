window.Yiipal = {behaviors: {}};
var bootstrapButton = jQuery.fn.button.noConflict();
jQuery.fn.bootstrapBtn = bootstrapButton;
(function (domready, Yiipal, yiipalSettings) {


    /**
     * Custom error type thrown after attach/detach if one or more behaviors failed.
     *
     * @param list
     *   An array of errors thrown during attach/detach.
     * @param event
     *   A string containing either 'attach' or 'detach'.
     */
    function YiipalBehaviorError(list, event) {
        this.name = 'YiipalBehaviorError';
        this.event = event || 'attach';
        this.list = list;
        // Makes the list of errors readable.
        var messageList = [];
        messageList.push(this.event);
        var il = this.list.length;
        for (var i = 0; i < il; i++) {
            messageList.push(this.list[i].behavior + ': ' + this.list[i].error.message);
        }
        this.message = messageList.join(' ; ');
    }

    YiipalBehaviorError.prototype = new Error();

    /**
     * Attach all registered behaviors to a page element.
     *
     * Behaviors are event-triggered actions that attach to page elements, enhancing
     * default non-JavaScript UIs. Behaviors are registered in the Yiipal.behaviors
     * object using the method 'attach' and optionally also 'detach' as follows:
     * @code
     *    Yiipal.behaviors.behaviorName = {
   *      attach: function (context, settings) {
   *        ...
   *      },
   *      detach: function (context, settings, trigger) {
   *        ...
   *      }
   *    };
     * @endcode
     *
     * Yiipal.attachBehaviors is added below to the jQuery.ready event and therefore
     * runs on initial page load. Developers implementing Ajax in their solutions
     * should also call this function after new page content has been loaded,
     * feeding in an element to be processed, in order to attach all behaviors to
     * the new content.
     *
     * Behaviors should use
     * @code
     *   var elements = $(context).find(selector).once('behavior-name');
     * @endcode
     * to ensure the behavior is attached only once to a given element. (Doing so
     * enables the reprocessing of given elements, which may be needed on occasion
     * despite the ability to limit behavior attachment to a particular element.)
     *
     * @param context
     *   An element to attach behaviors to. If none is given, the document element
     *   is used.
     * @param settings
     *   An object containing settings for the current context. If none is given,
     *   the global yiipalSettings object is used.
     */
    Yiipal.attachBehaviors = function (context, settings) {
        context = context || document;
        settings = settings || yiipalSettings;
        var errors = [];
        var behaviors = Yiipal.behaviors;
        // Execute all of them.
        for (var i in behaviors) {
            if (behaviors.hasOwnProperty(i) && typeof behaviors[i].attach === 'function') {
                // Don't stop the execution of behaviors in case of an error.
                try {
                    behaviors[i].attach(context, settings);
                }
                catch (e) {
                    errors.push({behavior: i, error: e});
                }
            }
        }
        // Once all behaviors have been processed, inform the user about errors.
        if (errors.length) {
            throw new YiipalBehaviorError(errors, 'attach');
        }
    };

    // Attach all behaviors.
    domready(function () { Yiipal.attachBehaviors(document, yiipalSettings); });

    /**
     * Detach registered behaviors from a page element.
     *
     * Developers implementing AHAH/Ajax in their solutions should call this
     * function before page content is about to be removed, feeding in an element
     * to be processed, in order to allow special behaviors to detach from the
     * content.
     *
     * Such implementations should use .findOnce() and .removeOnce() to find
     * elements with their corresponding Yiipal.behaviors.behaviorName.attach
     * implementation, i.e. .removeOnce('behaviorName'), to ensure the behavior is
     * detached only from previously processed elements.
     *
     * @param context
     *   An element to detach behaviors from. If none is given, the document element
     *   is used.
     * @param settings
     *   An object containing settings for the current context. If none given, the
     *   global yiipalSettings object is used.
     * @param trigger
     *   A string containing what's causing the behaviors to be detached. The
     *   possible triggers are:
     *   - unload: (default) The context element is being removed from the DOM.
     *   - move: The element is about to be moved within the DOM (for example,
     *     during a tabledrag row swap). After the move is completed,
     *     Yiipal.attachBehaviors() is called, so that the behavior can undo
     *     whatever it did in response to the move. Many behaviors won't need to
     *     do anything simply in response to the element being moved, but because
     *     IFRAME elements reload their "src" when being moved within the DOM,
     *     behaviors bound to IFRAME elements (like WYSIWYG editors) may need to
     *     take some action.
     *   - serialize: When an Ajax form is submitted, this is called with the
     *     form as the context. This provides every behavior within the form an
     *     opportunity to ensure that the field elements have correct content
     *     in them before the form is serialized. The canonical use-case is so
     *     that WYSIWYG editors can update the hidden textarea to which they are
     *     bound.
     *
     * @see Yiipal.attachBehaviors
     */
    Yiipal.detachBehaviors = function (context, settings, trigger) {
        context = context || document;
        settings = settings || yiipalSettings;
        trigger = trigger || 'unload';
        var errors = [];
        var behaviors = Yiipal.behaviors;
        // Execute all of them.
        for (var i in behaviors) {
            if (behaviors.hasOwnProperty(i) && typeof behaviors[i].detach === 'function') {
                // Don't stop the execution of behaviors in case of an error.
                try {
                    behaviors[i].detach(context, settings, trigger);
                }
                catch (e) {
                    errors.push({behavior: i, error: e});
                }
            }
        }
        // Once all behaviors have been processed, inform the user about errors.
        if (errors.length) {
            throw new YiipalBehaviorError(errors, 'detach:' + trigger);
        }
    };

})(domready, Yiipal, window.yiipalSettings);